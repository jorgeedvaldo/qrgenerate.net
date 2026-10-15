<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_register_screen_is_reachable_in_both_languages(): void
    {
        $this->get('/register')->assertOk()->assertSee('Create your account');
        $this->get('/pt/criar-conta')->assertOk()->assertSee('Criar a sua conta');
    }

    public function test_a_visitor_can_register_with_an_email_and_password(): void
    {
        $response = $this->post('/pt/criar-conta', [
            'name'                  => 'Aurora Quiari',
            'email'                 => 'aurora@example.test',
            'password'              => 'segredo-forte',
            'password_confirmation' => 'segredo-forte',
        ]);

        $response->assertRedirect(route('invitations.index'));
        $this->assertAuthenticated();

        $user = User::firstWhere('email', 'aurora@example.test');
        $this->assertSame('Aurora Quiari', $user->name);
        $this->assertSame('pt', $user->locale);
        $this->assertTrue(Hash::check('segredo-forte', $user->password));
    }

    public function test_the_locale_follows_the_url_the_visitor_registered_from(): void
    {
        $this->post('/register', [
            'name'                  => 'Jane Doe',
            'email'                 => 'jane@example.test',
            'password'              => 'strong-secret',
            'password_confirmation' => 'strong-secret',
        ])->assertRedirect(route('invitations.index'));

        $this->assertSame('en', User::firstWhere('email', 'jane@example.test')->locale);
    }

    public function test_registration_rejects_a_duplicate_email(): void
    {
        User::factory()->create(['email' => 'taken@example.test']);

        $this->post('/register', [
            'name'                  => 'Someone Else',
            'email'                 => 'taken@example.test',
            'password'              => 'strong-secret',
            'password_confirmation' => 'strong-secret',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_registration_requires_a_confirmed_password_of_at_least_eight_characters(): void
    {
        $this->post('/register', [
            'name'                  => 'Short Pass',
            'email'                 => 'short@example.test',
            'password'              => 'abc123',
            'password_confirmation' => 'abc123',
        ])->assertSessionHasErrors('password');

        $this->post('/register', [
            'name'                  => 'Mismatch',
            'email'                 => 'mismatch@example.test',
            'password'              => 'strong-secret',
            'password_confirmation' => 'different-secret',
        ])->assertSessionHasErrors('password');

        $this->assertGuest();
    }
}
