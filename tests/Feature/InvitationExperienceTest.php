<?php

namespace Tests\Feature;

use App\Models\Invitation;
use App\Models\InvitationGuest;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The parts of the public page that make it feel like an invitation rather
 * than a form: the envelope, the programme, the guest handbook and the
 * printable keepsake.
 */
class InvitationExperienceTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_envelope_intro_is_shown_and_keeps_the_page_hidden_until_opened(): void
    {
        Invitation::factory()->create(['slug' => 'aurora-e-quiari', 'envelope_enabled' => true]);

        $response = $this->get('/convite/aurora-e-quiari');

        $response->assertOk()
            ->assertSee('id="envelope-screen"', false)
            ->assertSee('Toque para abrir o convite')
            ->assertSee('class="stage "', false);
    }

    public function test_without_the_envelope_the_page_is_visible_immediately(): void
    {
        Invitation::factory()->create(['slug' => 'aurora-e-quiari', 'envelope_enabled' => false]);

        $this->get('/convite/aurora-e-quiari')
            ->assertOk()
            ->assertDontSee('id="envelope-screen"', false)
            ->assertSee('class="stage show"', false);
    }

    public function test_the_seal_shows_the_monogram_or_falls_back_to_the_initials(): void
    {
        $custom = Invitation::factory()->create(['slug' => 'com-monograma', 'monogram' => 'A & Q']);
        $this->assertSame('A & Q', $custom->monogramText());

        $derived = Invitation::factory()->create([
            'slug'             => 'sem-monograma',
            'monogram'         => null,
            'partner_one_name' => 'Aurora',
            'partner_two_name' => 'Quiari',
        ]);
        $this->assertSame('A & Q', $derived->monogramText());

        $single = Invitation::factory()->create([
            'slug'             => 'so-um-nome',
            'monogram'         => null,
            'partner_one_name' => 'Aurora',
            'partner_two_name' => null,
        ]);
        $this->assertSame('A', $single->monogramText());
    }

    public function test_the_petals_and_mascot_can_be_switched_off(): void
    {
        Invitation::factory()->create([
            'slug'            => 'aurora-e-quiari',
            'petals_enabled'  => false,
            'mascot_enabled'  => false,
        ]);

        $this->get('/convite/aurora-e-quiari')
            ->assertOk()
            ->assertDontSee('id="petals"', false)
            ->assertDontSee('<use href="#couple"', false);
    }

    public function test_the_programme_timeline_is_listed_in_order(): void
    {
        $invitation = Invitation::factory()->create(['slug' => 'aurora-e-quiari']);
        $invitation->scheduleItems()->create(['time' => '20:00', 'title' => 'Jantar', 'sort_order' => 1]);
        $invitation->scheduleItems()->create(['time' => '18:00', 'title' => 'Receção dos convidados', 'description' => 'Boas-vindas e fotos.', 'sort_order' => 0]);

        $response = $this->get('/convite/aurora-e-quiari');

        $response->assertOk()
            ->assertSee('Programa da noite')
            ->assertSee('Boas-vindas e fotos.')
            ->assertSeeInOrder(['Receção dos convidados', 'Jantar']);

        $this->assertSame('18:00:00', $invitation->scheduleItems->first()->time);
    }

    public function test_the_programme_section_is_absent_without_items(): void
    {
        Invitation::factory()->create(['slug' => 'aurora-e-quiari']);

        $this->get('/convite/aurora-e-quiari')->assertDontSee('Programa da noite');
    }

    public function test_the_guest_handbook_renders_each_tip(): void
    {
        Invitation::factory()->create([
            'slug'       => 'aurora-e-quiari',
            'guest_tips' => [
                ['icon' => 'clock', 'text' => 'Por favor, sejam pontuais'],
                ['icon' => 'dress', 'text' => 'Traje elegante'],
            ],
        ]);

        $this->get('/convite/aurora-e-quiari')
            ->assertOk()
            ->assertSee('Manual do bom convidado')
            ->assertSee('Por favor, sejam pontuais')
            ->assertSee('Traje elegante');
    }

    public function test_ride_hailing_links_are_shown_next_to_the_venue(): void
    {
        $invitation = Invitation::factory()->create([
            'slug'       => 'aurora-e-quiari',
            'ride_links' => [['label' => 'Pedir no Yango', 'url' => 'https://yango.com/r/luanda']],
        ]);
        $invitation->events()->create(['kind' => 'party', 'title' => 'Festa', 'address' => 'Zango I, Luanda']);

        $this->get('/convite/aurora-e-quiari')
            ->assertOk()
            ->assertSee('Pedir no Yango')
            ->assertSee('https://yango.com/r/luanda', false);
    }

    public function test_the_venue_offers_both_map_apps_and_a_copy_button(): void
    {
        $invitation = Invitation::factory()->create(['slug' => 'aurora-e-quiari']);
        $invitation->events()->create(['kind' => 'party', 'title' => 'Festa', 'venue_name' => 'Zango I', 'address' => 'Zango I, Luanda']);

        $this->get('/convite/aurora-e-quiari')
            ->assertOk()
            ->assertSee('maps.apple.com', false)
            ->assertSee('google.com/maps', false)
            ->assertSee('Copiar endereço');
    }

    public function test_the_keepsake_card_names_the_guest_it_was_sent_to(): void
    {
        $invitation = Invitation::factory()->create(['slug' => 'aurora-e-quiari']);
        InvitationGuest::factory()->for($invitation)->create(['name' => 'Onésimo e Edvaldo', 'code' => 'onesimo-e-edvaldo']);

        $this->get('/convite/aurora-e-quiari?c=onesimo-e-edvaldo')
            ->assertOk()
            ->assertSee('Convidado(a) de honra')
            ->assertSee('Onésimo e Edvaldo', false)
            ->assertSee('Baixar / imprimir convite');
    }

    public function test_the_keepsake_card_falls_back_when_nobody_is_named(): void
    {
        Invitation::factory()->create(['slug' => 'aurora-e-quiari']);

        $this->get('/convite/aurora-e-quiari')
            ->assertOk()
            ->assertSee('Convidado(a) de honra');
    }

    public function test_a_guest_can_suggest_a_song_for_the_dj(): void
    {
        $invitation = Invitation::factory()->create(['slug' => 'aurora-e-quiari', 'song_request_enabled' => true]);

        $this->get('/convite/aurora-e-quiari')->assertSee('id="rsvp-song"', false);

        $this->post('/convite/aurora-e-quiari/confirmar', [
            'name'         => 'Tia Maria',
            'attending'    => '1',
            'song_request' => 'Bonga — Mona Ki Ngi Xica',
        ]);

        $this->assertSame('Bonga — Mona Ki Ngi Xica', $invitation->rsvps()->first()->song_request);
    }

    public function test_the_song_request_field_can_be_switched_off(): void
    {
        Invitation::factory()->create(['slug' => 'aurora-e-quiari', 'song_request_enabled' => false]);

        // The WhatsApp message builder always mentions the DJ, so look for the field.
        $this->get('/convite/aurora-e-quiari')->assertDontSee('id="rsvp-song"', false);
    }

    public function test_the_song_request_reaches_the_csv_for_the_dj(): void
    {
        $user = User::factory()->create();
        $invitation = Invitation::factory()->for($user)->create();
        $invitation->rsvps()->create([
            'name' => 'Tia Maria', 'attending' => true, 'song_request' => 'Bonga — Mona Ki Ngi Xica',
        ]);

        $response = $this->actingAs($user)->get(route('invitations.rsvps.csv', $invitation->slug));

        $response->assertOk();
        $content = $response->streamedContent();
        $this->assertStringContainsString('Música para o DJ', $content);
        $this->assertStringContainsString('Bonga — Mona Ki Ngi Xica', $content);
    }

    public function test_whatsapp_mode_replaces_the_site_form_with_a_whatsapp_button(): void
    {
        Invitation::factory()->create([
            'slug'             => 'aurora-e-quiari',
            'rsvp_mode'        => 'whatsapp',
            'contact_whatsapp' => '+244 943 184 239',
        ]);

        $this->get('/convite/aurora-e-quiari')
            ->assertOk()
            ->assertSee('Confirmar via WhatsApp')
            ->assertDontSee('Enviar resposta')
            ->assertSee('244943184239', false);
    }

    public function test_both_mode_offers_the_site_form_and_whatsapp(): void
    {
        Invitation::factory()->create([
            'slug'             => 'aurora-e-quiari',
            'rsvp_mode'        => 'both',
            'contact_whatsapp' => '244943184239',
        ]);

        $this->get('/convite/aurora-e-quiari')
            ->assertSee('Enviar resposta')
            ->assertSee('Confirmar via WhatsApp');
    }

    public function test_whatsapp_mode_without_a_number_cannot_offer_whatsapp(): void
    {
        $invitation = Invitation::factory()->create([
            'rsvp_mode'        => 'whatsapp',
            'contact_whatsapp' => null,
        ]);

        $this->assertFalse($invitation->rsvpOnWhatsapp());
        $this->assertFalse($invitation->rsvpOnSite());
    }

    public function test_a_disabled_rsvp_closes_both_routes(): void
    {
        $invitation = Invitation::factory()->create([
            'rsvp_enabled'     => false,
            'rsvp_mode'        => 'both',
            'contact_whatsapp' => '244943184239',
        ]);

        $this->assertFalse($invitation->rsvpOnSite());
        $this->assertFalse($invitation->rsvpOnWhatsapp());
    }

    public function test_the_nav_only_lists_sections_that_have_content(): void
    {
        $invitation = Invitation::factory()->create([
            'slug'              => 'aurora-e-quiari',
            'story'             => null,
            'guestbook_enabled' => false,
            'guest_tips'        => null,
            'dress_code'        => null,
            'dress_code_notes'  => null,
        ]);
        $invitation->scheduleItems()->create(['time' => '18:00', 'title' => 'Receção']);

        $response = $this->get('/convite/aurora-e-quiari');

        $response->assertOk()
            ->assertSee('data-target="programa"', false)
            ->assertDontSee('data-target="historia"', false)
            ->assertDontSee('data-target="recados"', false)
            ->assertDontSee('data-target="manual"', false);
    }
}
