<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_login_screen_is_reachable_in_both_languages(): void
    {
        $this->get('/login')->assertOk()->assertSee('Continue with Google');
        $this->get('/pt/entrar')->assertOk()->assertSee('Continuar com Google');
    }

    public function test_a_user_can_sign_in_with_their_password(): void
    {
        $user = User::factory()->create(['email' => 'aurora@example.test']);

        $this->post('/pt/entrar', [
            'email'    => 'aurora@example.test',
            'password' => 'password',
        ])->assertRedirect(route('invitations.index'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_a_wrong_password_is_rejected(): void
    {
        User::factory()->create(['email' => 'aurora@example.test']);

        $this->post('/login', [
            'email'    => 'aurora@example.test',
            'password' => 'not-the-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_a_google_only_account_is_told_to_use_the_google_button(): void
    {
        User::factory()->create([
            'email'     => 'google-user@example.test',
            'password'  => null,
            'google_id' => '1234567890',
        ]);

        $this->post('/pt/entrar', [
            'email'    => 'google-user@example.test',
            'password' => 'anything',
        ])->assertSessionHasErrors(['email' => 'Esta conta foi criada com o Google. Entre com o botão "Continuar com Google".']);

        $this->assertGuest();
    }

    public function test_a_signed_in_user_can_sign_out(): void
    {
        $user = User::factory()->create(['locale' => 'pt']);

        $this->actingAs($user)->post('/logout')->assertRedirect('/pt');

        $this->assertGuest();
    }

    public function test_signed_in_users_are_sent_away_from_the_login_screen(): void
    {
        $this->actingAs(User::factory()->create())->get('/login')->assertRedirect();
    }
}
