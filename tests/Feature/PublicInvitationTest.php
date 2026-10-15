<?php

namespace Tests\Feature;

use App\Models\Invitation;
use App\Models\InvitationGuest;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicInvitationTest extends TestCase
{
    use RefreshDatabase;

    public function test_anyone_can_open_an_invitation_without_signing_in(): void
    {
        $invitation = Invitation::factory()->create([
            'slug'             => 'aurora-e-edvaldo',
            'partner_one_name' => 'Aurora',
            'partner_two_name' => 'Edvaldo',
            'tagline'          => 'E assim começa a nossa história',
        ]);

        $this->get('/convite/aurora-e-edvaldo')
            ->assertOk()
            ->assertSee('Aurora')
            ->assertSee('Edvaldo')
            ->assertSee('E assim começa a nossa história');
    }

    public function test_a_hidden_or_unknown_invitation_is_not_found(): void
    {
        $hidden = Invitation::factory()->hidden()->create(['slug' => 'escondido']);

        $this->get('/convite/escondido')->assertNotFound();
        $this->get('/convite/nao-existe')->assertNotFound();
    }

    public function test_a_registered_guest_code_greets_the_guest_by_name(): void
    {
        $invitation = Invitation::factory()->create(['slug' => 'aurora-e-edvaldo']);
        $guest = InvitationGuest::factory()->for($invitation)->create([
            'name' => 'Onésimo e Edvaldo',
            'code' => 'onesimo-e-edvaldo',
        ]);

        $this->get('/convite/aurora-e-edvaldo?c=onesimo-e-edvaldo')
            ->assertOk()
            ->assertSee('Convite especial para')
            ->assertSee('Onésimo e Edvaldo', false);

        $this->assertNotNull($guest->fresh()->opened_at, 'Opening a personalised link should be recorded.');
    }

    public function test_a_free_text_c_parameter_is_shown_as_a_name(): void
    {
        Invitation::factory()->create(['slug' => 'aurora-e-edvaldo']);

        $this->get('/convite/aurora-e-edvaldo?c=' . urlencode('Família Quiari'))
            ->assertOk()
            ->assertSee('Família Quiari', false);
    }

    public function test_a_c_parameter_cannot_inject_markup(): void
    {
        Invitation::factory()->create(['slug' => 'aurora-e-edvaldo']);

        $response = $this->get('/convite/aurora-e-edvaldo?c=' . urlencode('<script>alert(1)</script>'));

        $response->assertOk();
        $this->assertStringNotContainsString('<script>alert(1)</script>', $response->getContent());
    }

    public function test_opening_an_invitation_counts_a_view(): void
    {
        $invitation = Invitation::factory()->create(['slug' => 'aurora-e-edvaldo']);

        $this->get('/convite/aurora-e-edvaldo');
        $this->get('/convite/aurora-e-edvaldo');

        $this->assertSame(2, (int) $invitation->fresh()->view_count);
    }

    public function test_a_guest_can_confirm_attendance(): void
    {
        $invitation = Invitation::factory()->create(['slug' => 'aurora-e-edvaldo', 'max_companions' => 2]);
        $guest = InvitationGuest::factory()->for($invitation)->create(['code' => 'tia-maria']);

        $this->post('/convite/aurora-e-edvaldo/confirmar', [
            'name'            => 'Tia Maria',
            'email'           => 'tia@example.test',
            'attending'       => '1',
            'companions'      => '2',
            'companion_names' => 'Zé, Joana',
            'message'         => 'Parabéns aos dois!',
            'guest_code'      => 'tia-maria',
        ])->assertRedirect($invitation->publicUrl('tia-maria') . '#rsvp');

        $rsvp = $invitation->rsvps()->first();
        $this->assertSame('Tia Maria', $rsvp->name);
        $this->assertTrue($rsvp->attending);
        $this->assertSame(2, $rsvp->companions);
        $this->assertSame($guest->id, $rsvp->invitation_guest_id);
        $this->assertSame(3, $rsvp->partySize());
        $this->assertNotNull($rsvp->ip_hash);
    }

    public function test_a_guest_can_decline_and_companions_are_dropped(): void
    {
        $invitation = Invitation::factory()->create(['slug' => 'aurora-e-edvaldo']);

        $this->post('/convite/aurora-e-edvaldo/confirmar', [
            'name'            => 'Primo Carlos',
            'attending'       => '0',
            'companions'      => '2',
            'companion_names' => 'Alguém',
        ])->assertSessionHas('rsvp_done', 'no');

        $rsvp = $invitation->rsvps()->first();
        $this->assertFalse($rsvp->attending);
        $this->assertSame(0, $rsvp->companions);
        $this->assertNull($rsvp->companion_names);
        $this->assertSame(0, $rsvp->partySize());
    }

    public function test_more_companions_than_allowed_is_rejected(): void
    {
        Invitation::factory()->create(['slug' => 'aurora-e-edvaldo', 'max_companions' => 1]);

        $this->post('/convite/aurora-e-edvaldo/confirmar', [
            'name'       => 'Tia Maria',
            'attending'  => '1',
            'companions' => '5',
        ])->assertSessionHasErrors('companions');
    }

    public function test_companions_are_refused_when_the_couple_turned_them_off(): void
    {
        Invitation::factory()->create([
            'slug'             => 'aurora-e-edvaldo',
            'allow_companions' => false,
            'max_companions'   => 4,
        ]);

        $this->post('/convite/aurora-e-edvaldo/confirmar', [
            'name'       => 'Tia Maria',
            'attending'  => '1',
            'companions' => '1',
        ])->assertSessionHasErrors('companions');
    }

    public function test_replies_are_refused_after_the_deadline(): void
    {
        $invitation = Invitation::factory()->create([
            'slug'          => 'aurora-e-edvaldo',
            'rsvp_deadline' => now()->subDay()->toDateString(),
        ]);

        $this->post('/convite/aurora-e-edvaldo/confirmar', [
            'name'      => 'Tia Maria',
            'attending' => '1',
        ])->assertSessionHasErrors('rsvp');

        $this->assertSame(0, $invitation->rsvps()->count());
    }

    public function test_the_rsvp_form_is_hidden_when_the_couple_turned_it_off(): void
    {
        Invitation::factory()->create(['slug' => 'aurora-e-edvaldo', 'rsvp_enabled' => false]);

        $this->get('/convite/aurora-e-edvaldo')
            ->assertOk()
            ->assertDontSee('Confirme a sua presença');
    }

    public function test_a_guest_can_leave_a_note_in_the_guestbook(): void
    {
        $invitation = Invitation::factory()->create(['slug' => 'aurora-e-edvaldo']);

        $this->post('/convite/aurora-e-edvaldo/recado', [
            'name'    => 'Mana Luísa',
            'message' => 'Que felicidade! Deus abençoe.',
        ])->assertRedirect($invitation->publicUrl() . '#recados');

        $this->assertDatabaseHas('invitation_messages', [
            'invitation_id' => $invitation->id,
            'name'          => 'Mana Luísa',
            'is_approved'   => true,
        ]);

        $this->get('/convite/aurora-e-edvaldo')->assertSee('Que felicidade! Deus abençoe.');
    }

    public function test_the_guestbook_is_closed_when_the_couple_turned_it_off(): void
    {
        Invitation::factory()->create(['slug' => 'aurora-e-edvaldo', 'guestbook_enabled' => false]);

        $this->post('/convite/aurora-e-edvaldo/recado', [
            'name'    => 'Mana Luísa',
            'message' => 'Parabéns!',
        ])->assertNotFound();
    }

    public function test_a_guest_can_reserve_a_gift_only_once(): void
    {
        $invitation = Invitation::factory()->create(['slug' => 'aurora-e-edvaldo']);
        $gift = $invitation->gifts()->create(['name' => 'Jogo de panelas']);

        $this->post("/convite/aurora-e-edvaldo/presente/{$gift->id}", ['reserved_by' => 'Tia Maria'])
            ->assertSessionHas('gift_done', 'Jogo de panelas');

        $gift->refresh();
        $this->assertTrue($gift->is_reserved);
        $this->assertSame('Tia Maria', $gift->reserved_by);

        // A second guest must not be able to take the same gift.
        $this->post("/convite/aurora-e-edvaldo/presente/{$gift->id}", ['reserved_by' => 'Primo Carlos'])
            ->assertSessionHasErrors('gift');

        $this->assertSame('Tia Maria', $gift->fresh()->reserved_by);
    }

    public function test_a_gift_from_another_invitation_cannot_be_reserved(): void
    {
        Invitation::factory()->create(['slug' => 'aurora-e-edvaldo']);
        $other = Invitation::factory()->create();
        $gift = $other->gifts()->create(['name' => 'Jogo de panelas']);

        $this->post("/convite/aurora-e-edvaldo/presente/{$gift->id}", ['reserved_by' => 'Tia Maria'])
            ->assertNotFound();

        $this->assertFalse($gift->fresh()->is_reserved);
    }

    public function test_the_invitation_page_is_kept_out_of_search_results(): void
    {
        Invitation::factory()->create(['slug' => 'aurora-e-edvaldo']);

        $this->get('/convite/aurora-e-edvaldo')
            ->assertSee('name="robots" content="noindex, nofollow"', false);
    }
}
