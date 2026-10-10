<?php

namespace Tests\Feature;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InvitationManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_dashboard_requires_signing_in(): void
    {
        $this->get(route('invitations.index'))->assertRedirect(route('login'));
        $this->get(route('invitations.create'))->assertRedirect(route('login'));
    }

    public function test_the_dashboard_lists_only_the_signed_in_users_invitations(): void
    {
        $user = User::factory()->create();
        $mine = Invitation::factory()->for($user)->create(['partner_one_name' => 'Aurora']);
        $theirs = Invitation::factory()->create(['partner_one_name' => 'Someone']);

        $this->actingAs($user)->get(route('invitations.index'))
            ->assertOk()
            ->assertSee('Aurora')
            ->assertDontSee($theirs->partner_one_name);
    }

    public function test_the_landing_pages_are_public_in_both_languages(): void
    {
        $this->get('/wedding-invitation-generator')->assertOk()->assertSee('Online Invitation', false);
        $this->get('/pt/convite-de-casamento-online')->assertOk()->assertSee('Convite Virtual', false);
    }

    public function test_a_user_can_create_an_invitation_with_events_gifts_and_photos(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('invitations.store'), $this->payload());

        $invitation = Invitation::firstWhere('partner_one_name', 'Aurora');

        $this->assertNotNull($invitation);
        $response->assertRedirect(route('invitations.share', $invitation->slug));

        $this->assertSame($user->id, $invitation->user_id);
        $this->assertSame('aurora-e-edvaldo', $invitation->slug);
        $this->assertSame('engagement', $invitation->type);
        $this->assertSame('15:30:00', $invitation->event_time);
        $this->assertTrue($invitation->rsvp_enabled);
        $this->assertFalse($invitation->guestbook_enabled);

        $this->assertCount(2, $invitation->events);
        $this->assertSame('Cerimónia', $invitation->events->first()->title);
        $this->assertSame('reception', $invitation->events->last()->kind);

        $this->assertCount(1, $invitation->gifts);
        $this->assertSame('Jogo de panelas', $invitation->gifts->first()->name);

        $this->assertCount(1, $invitation->photos);
        $this->assertSame('Noivado', $invitation->photos->first()->caption);

        $this->assertSame('A & Q', $invitation->monogram);
        $this->assertSame('both', $invitation->rsvp_mode);
        $this->assertTrue($invitation->envelope_enabled);
        $this->assertFalse($invitation->petals_enabled, 'An unchecked switch must store false.');

        $this->assertCount(2, $invitation->scheduleItems);
        $this->assertSame('Receção dos convidados', $invitation->scheduleItems->first()->title);
        $this->assertSame('18:00:00', $invitation->scheduleItems->first()->time);

        $this->assertCount(2, $invitation->guest_tips);
        $this->assertSame('clock', $invitation->guest_tips[0]['icon']);
        $this->assertCount(1, $invitation->ride_links);
        $this->assertSame('Pedir no Yango', $invitation->ride_links[0]['label']);
    }

    public function test_blank_repeater_rows_are_skipped(): void
    {
        $user = User::factory()->create();

        $payload = $this->payload();
        $payload['events'][] = ['kind' => 'party', 'title' => ''];
        $payload['gifts'][] = ['name' => '', 'price' => '12'];
        $payload['photos'][] = ['image_url' => '', 'caption' => 'no image'];
        $payload['schedule'][] = ['time' => '22:00', 'title' => ''];
        $payload['tips'][] = ['icon' => 'heart', 'text' => ''];
        $payload['rides'][] = ['label' => 'Sem link', 'url' => ''];

        $this->actingAs($user)->post(route('invitations.store'), $payload);

        $invitation = Invitation::firstWhere('partner_one_name', 'Aurora');
        $this->assertCount(2, $invitation->events);
        $this->assertCount(1, $invitation->gifts);
        $this->assertCount(1, $invitation->photos);
        $this->assertCount(2, $invitation->scheduleItems);
        $this->assertCount(2, $invitation->guest_tips);
        $this->assertCount(1, $invitation->ride_links);
    }

    public function test_creating_an_invitation_requires_a_name_and_a_date(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('invitations.store'), ['type' => 'wedding'])
            ->assertSessionHasErrors(['partner_one_name', 'event_date']);

        $this->assertSame(0, Invitation::count());
    }

    public function test_the_slug_stays_unique_across_couples_with_the_same_names(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('invitations.store'), $this->payload());
        $this->actingAs($user)->post(route('invitations.store'), $this->payload());

        $this->assertSame(
            ['aurora-e-edvaldo', 'aurora-e-edvaldo-2'],
            Invitation::orderBy('id')->pluck('slug')->all()
        );
    }

    public function test_a_user_can_update_their_invitation(): void
    {
        $user = User::factory()->create();
        $invitation = Invitation::factory()->for($user)->create(['slug' => 'aurora-e-edvaldo']);

        $payload = $this->payload();
        $payload['tagline'] = 'Uma nova frase';
        $payload['events'] = [['kind' => 'ceremony', 'title' => 'Só a cerimónia']];

        $this->actingAs($user)
            ->put(route('invitations.update', $invitation->slug), $payload)
            ->assertRedirect(route('invitations.edit', $invitation->slug))
            ->assertSessionHas('status');

        $invitation->refresh();
        $this->assertSame('Uma nova frase', $invitation->tagline);
        $this->assertSame('aurora-e-edvaldo', $invitation->slug, 'The public link must not change on edit.');
        $this->assertCount(1, $invitation->events);
    }

    public function test_updating_the_gift_list_keeps_reservations_guests_already_made(): void
    {
        $user = User::factory()->create();
        $invitation = Invitation::factory()->for($user)->create();
        $invitation->gifts()->create([
            'name'        => 'Jogo de panelas',
            'is_reserved' => true,
            'reserved_by' => 'Tia Maria',
            'reserved_at' => now(),
        ]);

        $payload = $this->payload();
        $payload['gifts'] = [
            ['name' => 'Jogo de panelas', 'price' => '45000'],
            ['name' => 'Máquina de café'],
        ];

        $this->actingAs($user)->put(route('invitations.update', $invitation->slug), $payload);

        $gifts = $invitation->fresh()->gifts->keyBy('name');
        $this->assertTrue($gifts['Jogo de panelas']->is_reserved);
        $this->assertSame('Tia Maria', $gifts['Jogo de panelas']->reserved_by);
        $this->assertFalse($gifts['Máquina de café']->is_reserved);
    }

    public function test_a_user_cannot_see_or_change_someone_elses_invitation(): void
    {
        $intruder = User::factory()->create();
        $invitation = Invitation::factory()->create();

        $this->actingAs($intruder)->get(route('invitations.edit', $invitation->slug))->assertNotFound();
        $this->actingAs($intruder)->put(route('invitations.update', $invitation->slug), $this->payload())->assertNotFound();
        $this->actingAs($intruder)->delete(route('invitations.destroy', $invitation->slug))->assertNotFound();
        $this->actingAs($intruder)->get(route('invitations.rsvps', $invitation->slug))->assertNotFound();
        $this->actingAs($intruder)->get(route('invitations.guests', $invitation->slug))->assertNotFound();

        $this->assertDatabaseHas('invitations', ['id' => $invitation->id]);
    }

    public function test_a_user_can_delete_their_invitation_and_everything_attached_to_it(): void
    {
        $user = User::factory()->create();
        $invitation = Invitation::factory()->for($user)->create();
        $invitation->events()->create(['kind' => 'ceremony', 'title' => 'Cerimónia']);
        $invitation->scheduleItems()->create(['time' => '18:00', 'title' => 'Receção']);
        $invitation->rsvps()->create(['name' => 'Tia Maria', 'attending' => true]);
        $invitation->messages()->create(['name' => 'Tia Maria', 'message' => 'Parabéns!']);

        $this->actingAs($user)
            ->delete(route('invitations.destroy', $invitation->slug))
            ->assertRedirect(route('invitations.index'));

        $this->assertDatabaseMissing('invitations', ['id' => $invitation->id]);
        $this->assertDatabaseMissing('invitation_events', ['invitation_id' => $invitation->id]);
        $this->assertDatabaseMissing('invitation_schedule_items', ['invitation_id' => $invitation->id]);
        $this->assertDatabaseMissing('invitation_rsvps', ['invitation_id' => $invitation->id]);
        $this->assertDatabaseMissing('invitation_messages', ['invitation_id' => $invitation->id]);
    }

    public function test_an_uploaded_cover_photo_is_stored_and_linked(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $payload = $this->payload();
        $payload['cover_file'] = UploadedFile::fake()->image('capa.jpg');

        $this->actingAs($user)->post(route('invitations.store'), $payload);

        $invitation = Invitation::firstWhere('partner_one_name', 'Aurora');
        $this->assertStringStartsWith('/storage/invitations/aurora-e-edvaldo/', $invitation->cover_url);
        Storage::disk('public')->assertExists(str_replace('/storage/', '', $invitation->cover_url));
    }

    public function test_the_share_screen_shows_the_public_link(): void
    {
        $user = User::factory()->create();
        $invitation = Invitation::factory()->for($user)->create(['slug' => 'aurora-e-edvaldo']);

        $this->actingAs($user)->get(route('invitations.share', $invitation->slug))
            ->assertOk()
            ->assertSee($invitation->publicUrl());
    }

    public function test_the_rsvp_list_can_be_exported_as_csv(): void
    {
        $user = User::factory()->create();
        $invitation = Invitation::factory()->for($user)->create();
        $invitation->rsvps()->create(['name' => 'Tia Maria', 'attending' => true, 'companions' => 2]);

        $response = $this->actingAs($user)->get(route('invitations.rsvps.csv', $invitation->slug));

        $response->assertOk()->assertHeader('Content-Type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Tia Maria', $response->streamedContent());
    }

    /** A complete, valid create/update payload. */
    private function payload(): array
    {
        return [
            'type'             => 'engagement',
            'template'         => 'botanical',
            'font'             => 'cormorant',
            'partner_one_name' => 'Aurora',
            'partner_two_name' => 'Edvaldo',
            'tagline'          => 'E assim começa a nossa história',
            'story'            => 'Conhecemo-nos numa tarde de Março.',
            'event_date'       => '2026-12-19',
            'event_time'       => '15:30',
            'primary_color'    => '#b08968',
            'accent_color'     => '#7f5539',
            'rsvp_enabled'     => '1',
            'allow_companions' => '1',
            'max_companions'   => 2,
            'countdown_enabled' => '1',
            // guestbook_enabled deliberately absent: an unchecked switch.
            'events' => [
                ['kind' => 'ceremony', 'title' => 'Cerimónia', 'venue_name' => 'Igreja Sagrada Família',
                 'address' => 'Rua Amílcar Cabral, Luanda', 'event_time' => '15:30'],
                ['kind' => 'reception', 'title' => 'Recepção', 'venue_name' => 'Salão Talatona', 'event_time' => '18:00'],
            ],
            'monogram'          => 'A & Q',
            'envelope_enabled'  => '1',
            'mascot_enabled'    => '1',
            'rsvp_mode'         => 'both',
            'song_request_enabled' => '1',
            'contact_whatsapp'  => '244943184239',
            'schedule' => [
                ['time' => '18:00', 'title' => 'Receção dos convidados', 'description' => 'Boas-vindas e fotos.'],
                ['time' => '20:00', 'title' => 'Jantar'],
            ],
            'tips' => [
                ['icon' => 'clock', 'text' => 'Por favor, sejam pontuais'],
                ['icon' => 'dress', 'text' => 'Traje elegante'],
            ],
            'rides' => [['label' => 'Pedir no Yango', 'url' => 'https://yango.com/r/luanda']],
            'gifts'  => [['name' => 'Jogo de panelas', 'price' => '45000']],
            'photos' => [['image_url' => 'https://images.example.test/noivado.jpg', 'caption' => 'Noivado']],
        ];
    }
}
