<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_forgot_password_screen_is_reachable_in_both_languages(): void
    {
        $this->get('/forgot-password')->assertOk();
        $this->get('/pt/recuperar-senha')->assertOk();
    }

    public function test_a_reset_link_is_sent_and_points_at_the_account_language(): void
    {
        Notification::fake();
        $user = User::factory()->create(['email' => 'aurora@example.test', 'locale' => 'pt']);

        $this->post('/pt/recuperar-senha', ['email' => 'aurora@example.test'])
            ->assertSessionHas('status');

        Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use ($user) {
            $link = $notification->toMail($user)->actionUrl;

            return str_contains($link, '/pt/redefinir-senha/');
        });
    }

    public function test_the_form_does_not_reveal_whether_an_account_exists(): void
    {
        Notification::fake();

        $this->post('/forgot-password', ['email' => 'nobody@example.test'])
            ->assertSessionHas('status')
            ->assertSessionHasNoErrors();

        Notification::assertNothingSent();
    }

    public function test_a_user_can_set_a_new_password_with_a_valid_token(): void
    {
        Notification::fake();
        $user = User::factory()->create(['email' => 'aurora@example.test', 'locale' => 'pt']);

        $this->post('/pt/recuperar-senha', ['email' => 'aurora@example.test']);

        $token = null;
        Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use (&$token) {
            $token = $notification->token;

            return true;
        });

        $this->post('/pt/redefinir-senha', [
            'token'                 => $token,
            'email'                 => 'aurora@example.test',
            'password'              => 'uma-nova-senha',
            'password_confirmation' => 'uma-nova-senha',
        ])->assertRedirect(route('login.pt'));

        $this->assertTrue(Hash::check('uma-nova-senha', $user->fresh()->password));
    }

    public function test_an_invalid_token_is_rejected(): void
    {
        User::factory()->create(['email' => 'aurora@example.test']);

        $this->post('/reset-password', [
            'token'                 => 'not-a-real-token',
            'email'                 => 'aurora@example.test',
            'password'              => 'uma-nova-senha',
            'password_confirmation' => 'uma-nova-senha',
        ])->assertSessionHasErrors('email');
    }
}
