<?php

namespace Tests\Feature;

use App\Models\Invitation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * The ten invitation models. Each one keeps the same sections and the same
 * content — what changes is the dress: palette, typeface, the motif drawn in
 * the corners and whether the information cards are solid or transparent.
 */
class InvitationTemplateTest extends TestCase
{
    use RefreshDatabase;

    /** Motifs drawn by resources/views/invitations/_ornament.blade.php. */
    private const ORNAMENTS = [
        'none', 'wisteria', 'botanical', 'frame', 'roses',
        'palm', 'sprig', 'bough', 'wreath',
    ];

    public function test_the_site_offers_ten_templates(): void
    {
        $this->assertCount(10, config('invitation_templates'));
        $this->assertSame(array_keys(config('invitation_templates')), Invitation::templates());
    }

    public function test_every_template_is_fully_described(): void
    {
        foreach (config('invitation_templates') as $key => $tpl) {
            $this->assertMatchesRegularExpression('/^[a-z]+$/', $key, "template key {$key}");

            foreach (['pt', 'en'] as $lang) {
                $this->assertNotEmpty($tpl['label'][$lang] ?? null, "{$key} is missing its {$lang} label");
            }

            foreach (['primary', 'accent', 'paper', 'ink', 'foil', 'foil_light'] as $colour) {
                $this->assertMatchesRegularExpression(
                    '/^#[0-9a-f]{6}$/',
                    $tpl[$colour] ?? '',
                    "{$key}.{$colour} is not a hex colour"
                );
            }

            $this->assertContains($tpl['font'], Invitation::FONTS, "{$key} uses an unknown font");
            $this->assertContains($tpl['cards'], ['solid', 'outline'], "{$key} uses an unknown card treatment");
            $this->assertContains($tpl['ornament'], self::ORNAMENTS, "{$key} uses an undrawn ornament");
            $this->assertMatchesRegularExpression('/^\d+px$/', $tpl['radius'], "{$key}.radius is not a length");
        }
    }

    public function test_the_templates_are_visually_distinct(): void
    {
        $palettes = array_column(config('invitation_templates'), 'primary');
        $papers   = array_column(config('invitation_templates'), 'paper');

        $this->assertCount(10, array_unique($palettes), 'two templates share a primary colour');
        $this->assertCount(10, array_unique($papers), 'two templates share a paper colour');
    }

    public function test_an_unknown_template_key_falls_back_to_the_first_one(): void
    {
        $invitation = Invitation::factory()->create(['template' => 'classico']);

        // An invitation saved before a template was renamed must still render.
        $invitation->forceFill(['template' => 'um-modelo-que-ja-nao-existe']);

        $this->assertSame(config('invitation_templates.lilas'), $invitation->theme());
    }

    public function test_each_template_dresses_the_public_page_in_its_own_colours(): void
    {
        foreach (config('invitation_templates') as $key => $tpl) {
            $invitation = Invitation::factory()->create([
                'slug'     => "modelo-{$key}",
                'template' => $key,
            ]);

            $this->get("/convite/{$invitation->slug}")
                ->assertOk()
                ->assertSee('<body data-template="' . $key . '" data-cards="' . $tpl['cards'] . '"', false)
                ->assertSee('--paper: ' . $tpl['paper'], false)
                ->assertSee('--ink: ' . $tpl['ink'], false)
                ->assertSee('--gold: ' . $tpl['foil'], false);
        }
    }

    public function test_the_corner_motif_is_drawn_for_the_decorated_templates_only(): void
    {
        $withFlowers = Invitation::factory()->create(['slug' => 'com-flores', 'template' => 'lilas']);
        $bare        = Invitation::factory()->create(['slug' => 'sem-flores', 'template' => 'moderno']);

        $this->get('/convite/com-flores')
            ->assertOk()
            ->assertSee('class="orn-layer"', false)
            ->assertSee('<symbol id="orn"', false);

        $this->get('/convite/sem-flores')
            ->assertOk()
            ->assertDontSee('class="orn-layer"', false)
            ->assertDontSee('<symbol id="orn"', false);
    }

    public function test_the_information_cards_are_solid_or_transparent_as_the_template_says(): void
    {
        $solid   = Invitation::factory()->create(['slug' => 'cartoes-cheios', 'template' => 'lilas']);
        $outline = Invitation::factory()->create(['slug' => 'cartoes-vazios', 'template' => 'botanico']);

        $this->get('/convite/cartoes-cheios')->assertOk()->assertSee('data-cards="solid"', false);
        $this->get('/convite/cartoes-vazios')->assertOk()->assertSee('data-cards="outline"', false);
    }

    public function test_the_parents_are_announced_above_the_names(): void
    {
        Invitation::factory()->create([
            'slug'                => 'edivaldo-e-jerusa',
            'partner_one_parents' => "Sr. e Sra.\nBelmiro Cuna e Rosália Cuna",
            'partner_two_parents' => "Sr. e Sra.\nArmando Langa e Célia Langa",
        ]);

        $this->get('/convite/edivaldo-e-jerusa')
            ->assertOk()
            ->assertSee('class="parents"', false)
            ->assertSee('Belmiro Cuna e Rosália Cuna')
            ->assertSee('Armando Langa e Célia Langa');
    }

    public function test_an_invitation_without_parents_omits_the_block(): void
    {
        Invitation::factory()->create([
            'slug'                => 'sem-pais',
            'partner_one_parents' => null,
            'partner_two_parents' => null,
        ]);

        $this->get('/convite/sem-pais')
            ->assertOk()
            ->assertDontSee('class="parents"', false);
    }

    public function test_the_dress_code_shows_the_chosen_colour_palette(): void
    {
        Invitation::factory()->create([
            'slug'              => 'com-paleta',
            'dress_code'        => 'Traje formal',
            'dress_code_colors' => ['#d9cfc2', '#b4a089', '#8a7560'],
        ]);

        $response = $this->get('/convite/com-paleta')->assertOk()->assertSee('class="swatches"', false);

        foreach (['#d9cfc2', '#b4a089', '#8a7560'] as $swatch) {
            $response->assertSee('background:' . $swatch, false);
        }
    }

    public function test_the_month_calendar_marks_the_day_of_the_event(): void
    {
        $invitation = Invitation::factory()->create([
            'slug'       => 'com-calendario',
            'event_date' => '2027-06-12',
        ]);

        $this->get("/convite/{$invitation->slug}")
            ->assertOk()
            ->assertSee('junho de 2027')
            ->assertSee('<td class="on">', false);
    }

    public function test_the_gallery_counts_its_photos(): void
    {
        $invitation = Invitation::factory()->create(['slug' => 'com-galeria']);

        $invitation->photos()->create(['image_url' => 'https://exemplo.test/1.jpg', 'sort_order' => 1]);
        $invitation->photos()->create(['image_url' => 'https://exemplo.test/2.jpg', 'sort_order' => 2]);

        $this->get('/convite/com-galeria')->assertOk()->assertSee('2 fotos');

        $invitation->photos()->latest('id')->first()->delete();

        $this->get('/convite/com-galeria')->assertOk()->assertSee('1 foto');
    }

    public function test_the_builder_offers_a_card_for_every_template(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('invitations.create'))->assertOk();

        foreach (config('invitation_templates') as $key => $tpl) {
            $response->assertSee('value="' . $key . '"', false)
                ->assertSee('data-font="' . $tpl['font'] . '"', false)
                ->assertSee($tpl['label']['pt']);
        }
    }

    public function test_the_landing_pages_show_all_ten_templates(): void
    {
        $pt = $this->get(route('invitation.landing.pt'))->assertOk()->assertSee('Dez modelos de convite');
        $en = $this->get(route('invitation.landing.en'))->assertOk()->assertSee('Ten invitation templates');

        foreach (config('invitation_templates') as $tpl) {
            $pt->assertSee($tpl['label']['pt']);
            $en->assertSee($tpl['label']['en']);
        }
    }

    public function test_an_unknown_template_cannot_be_saved(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->post(route('invitations.store'), [
                'type'             => 'wedding',
                'template'         => 'inventado',
                'partner_one_name' => 'Edivaldo',
                'partner_two_name' => 'Jerusa',
                'event_date'       => now()->addYear()->toDateString(),
            ])
            ->assertSessionHasErrors('template');

        $this->assertDatabaseCount('invitations', 0);
    }
}
