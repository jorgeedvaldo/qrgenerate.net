<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Mockery;
use Tests\TestCase;

class GoogleAuthTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.google.client_id'     => 'test-client-id',
            'services.google.client_secret' => 'test-client-secret',
            'services.google.redirect'      => 'http://localhost/auth/google/callback',
        ]);
    }

    public function test_the_redirect_sends_the_visitor_to_google(): void
    {
        $response = $this->get('/auth/google/redirect?lang=pt');

        $response->assertRedirectContains('accounts.google.com');
        $this->assertSame('pt', session('auth_locale'));
    }

    public function test_the_redirect_falls_back_to_the_login_screen_when_google_is_not_configured(): void
    {
        config(['services.google.client_id' => null, 'services.google.client_secret' => null]);

        $this->get('/auth/google/redirect?lang=pt')
            ->assertRedirect(route('login.pt'))
            ->assertSessionHasErrors('email');
    }

    public function test_the_callback_creates_a_verified_account_for_a_new_google_user(): void
    {
        $this->fakeGoogleUser('900100', 'aurora@gmail.test', 'Aurora Quiari');

        $this->withSession(['auth_locale' => 'pt'])
            ->get('/auth/google/callback')
            ->assertRedirect(route('invitations.index'));

        $user = User::firstWhere('email', 'aurora@gmail.test');

        $this->assertNotNull($user);
        $this->assertSame('900100', $user->google_id);
        $this->assertSame('Aurora Quiari', $user->name);
        $this->assertSame('pt', $user->locale);
        $this->assertNull($user->password);
        $this->assertNotNull($user->email_verified_at);
        $this->assertAuthenticatedAs($user);
    }

    public function test_the_callback_links_google_to_an_account_that_already_used_that_email(): void
    {
        $existing = User::factory()->create([
            'email'     => 'aurora@gmail.test',
            'google_id' => null,
        ]);

        $this->fakeGoogleUser('900100', 'aurora@gmail.test', 'Aurora Quiari');

        $this->get('/auth/google/callback')->assertRedirect(route('invitations.index'));

        $existing->refresh();
        $this->assertSame('900100', $existing->google_id);
        $this->assertSame(1, User::count());
        $this->assertAuthenticatedAs($existing);
    }

    public function test_the_callback_signs_a_returning_google_user_back_in(): void
    {
        $existing = User::factory()->create([
            'email'     => 'changed@gmail.test',
            'google_id' => '900100',
        ]);

        // Google returns a different address; the stored google_id still matches.
        $this->fakeGoogleUser('900100', 'aurora@gmail.test', 'Aurora Quiari');

        $this->get('/auth/google/callback')->assertRedirect(route('invitations.index'));

        $this->assertSame(1, User::count());
        $this->assertAuthenticatedAs($existing);
    }

    public function test_the_callback_refuses_a_google_account_without_an_email(): void
    {
        $this->fakeGoogleUser('900100', null, 'No Email');

        $this->withSession(['auth_locale' => 'en'])
            ->get('/auth/google/callback')
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
        $this->assertSame(0, User::count());
    }

    private function fakeGoogleUser(string $id, ?string $email, string $name): void
    {
        $socialiteUser = (new SocialiteUser)->map([
            'id'     => $id,
            'name'   => $name,
            'email'  => $email,
            'avatar' => 'https://lh3.googleusercontent.test/avatar.png',
        ]);

        $provider = Mockery::mock(Provider::class);
        $provider->shouldReceive('user')->andReturn($socialiteUser);

        Socialite::shouldReceive('driver')->with('google')->andReturn($provider);
    }
}
