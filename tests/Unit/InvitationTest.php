<?php

namespace Tests\Unit;

use App\Models\Invitation;
use App\Models\InvitationEvent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class InvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_couple_names_join_both_partners(): void
    {
        $invitation = Invitation::factory()->make([
            'partner_one_name' => 'Aurora',
            'partner_two_name' => 'Edvaldo',
            'display_title'    => null,
        ]);

        $this->assertSame('Aurora & Edvaldo', $invitation->coupleNames());
    }

    public function test_couple_names_fall_back_to_one_name(): void
    {
        $invitation = Invitation::factory()->make([
            'partner_one_name' => 'Aurora',
            'partner_two_name' => null,
            'display_title'    => null,
        ]);

        $this->assertSame('Aurora', $invitation->coupleNames());
    }

    public function test_a_display_title_overrides_the_names(): void
    {
        $invitation = Invitation::factory()->make([
            'partner_one_name' => 'Aurora',
            'partner_two_name' => 'Edvaldo',
            'display_title'    => 'Bodas de Aurora & Edvaldo',
        ]);

        $this->assertSame('Bodas de Aurora & Edvaldo', $invitation->coupleNames());
    }

    public function test_starts_at_combines_the_date_and_time(): void
    {
        $invitation = Invitation::factory()->make([
            'event_date' => '2026-12-19',
            'event_time' => '15:30',
        ]);

        $this->assertSame('2026-12-19 15:30:00', $invitation->startsAt()->format('Y-m-d H:i:s'));
    }

    public function test_starts_at_falls_back_to_midnight_without_a_time(): void
    {
        $invitation = Invitation::factory()->make([
            'event_date' => '2026-12-19',
            'event_time' => null,
        ]);

        $this->assertSame('2026-12-19 00:00:00', $invitation->startsAt()->format('Y-m-d H:i:s'));
    }

    public function test_a_celebration_in_the_past_is_reported_as_past(): void
    {
        $this->assertTrue(Invitation::factory()->past()->make()->isPast());
        $this->assertFalse(Invitation::factory()->make()->isPast());
    }

    public function test_rsvp_is_open_until_the_deadline_then_closes(): void
    {
        $withDeadline = Invitation::factory()->make([
            'rsvp_enabled'  => true,
            'rsvp_deadline' => Carbon::now()->addDays(3)->toDateString(),
        ]);
        $this->assertTrue($withDeadline->rsvpOpen());

        $expired = Invitation::factory()->make([
            'rsvp_enabled'  => true,
            'rsvp_deadline' => Carbon::now()->subDay()->toDateString(),
        ]);
        $this->assertFalse($expired->rsvpOpen());
    }

    public function test_rsvp_closes_after_the_celebration_when_no_deadline_is_set(): void
    {
        $upcoming = Invitation::factory()->make(['rsvp_enabled' => true, 'rsvp_deadline' => null]);
        $this->assertTrue($upcoming->rsvpOpen());

        $past = Invitation::factory()->past()->make(['rsvp_enabled' => true, 'rsvp_deadline' => null]);
        $this->assertFalse($past->rsvpOpen());
    }

    public function test_rsvp_is_closed_when_the_couple_disabled_it(): void
    {
        $invitation = Invitation::factory()->make([
            'rsvp_enabled'  => false,
            'rsvp_deadline' => Carbon::now()->addYear()->toDateString(),
        ]);

        $this->assertFalse($invitation->rsvpOpen());
    }

    public function test_the_slug_is_built_from_both_names_and_stays_unique(): void
    {
        $this->assertSame('aurora-e-edvaldo', Invitation::generateUniqueSlug('Aurora', 'Edvaldo'));
        $this->assertSame('aurora', Invitation::generateUniqueSlug('Aurora', null));
        $this->assertSame('onesimo-e-edvaldo', Invitation::generateUniqueSlug('Onésimo', 'Edvaldo'));

        Invitation::factory()->create(['slug' => 'aurora-e-edvaldo']);
        $this->assertSame('aurora-e-edvaldo-2', Invitation::generateUniqueSlug('Aurora', 'Edvaldo'));
    }

    public function test_the_slug_falls_back_when_a_name_has_no_usable_characters(): void
    {
        $this->assertSame('convite', Invitation::generateUniqueSlug('???', null));
    }

    public function test_the_public_url_can_carry_a_guest_code(): void
    {
        $invitation = Invitation::factory()->make(['slug' => 'aurora-e-edvaldo']);

        $this->assertSame(url('/convite/aurora-e-edvaldo'), $invitation->publicUrl());
        $this->assertStringEndsWith('?c=tia-maria', $invitation->publicUrl('tia-maria'));
        $this->assertStringEndsWith('?c=Fam%C3%ADlia+Silva', $invitation->publicUrl('Família Silva'));
    }

    public function test_confirmed_count_adds_companions_to_the_guests(): void
    {
        $invitation = Invitation::factory()->create();
        $invitation->rsvps()->create(['name' => 'Tia Maria', 'attending' => true, 'companions' => 2]);
        $invitation->rsvps()->create(['name' => 'Primo Zé', 'attending' => true, 'companions' => 0]);
        $invitation->rsvps()->create(['name' => 'Mana Ana', 'attending' => false, 'companions' => 3]);

        $this->assertSame(4, $invitation->confirmedCount());
        $this->assertSame(1, $invitation->declinedCount());
    }

    public function test_an_event_builds_a_map_link_from_its_address(): void
    {
        $event = new InvitationEvent(['address' => 'Rua Amílcar Cabral, Luanda']);

        $this->assertStringStartsWith('https://www.google.com/maps/search/?api=1&query=', $event->mapsLink());
        $this->assertStringContainsString('Lu', $event->mapsLink());
    }

    public function test_an_explicit_map_url_wins_over_the_address(): void
    {
        $event = new InvitationEvent([
            'address'  => 'Rua Amílcar Cabral, Luanda',
            'maps_url' => 'https://maps.app.goo.gl/abc123',
        ]);

        $this->assertSame('https://maps.app.goo.gl/abc123', $event->mapsLink());
    }

    public function test_an_event_without_a_location_has_no_map_link(): void
    {
        $this->assertNull((new InvitationEvent)->mapsLink());
    }
}
