<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\InvalidStateException;

class GoogleAuthController extends Controller
{
    /** Send the user to Google's consent screen. */
    public function redirect(Request $request)
    {
        if (! $this->configured()) {
            return $this->unavailable($request);
        }

        // Remember which language the user started from so the flow comes back in it.
        $request->session()->put('auth_locale', $request->query('lang') === 'en' ? 'en' : 'pt');

        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    /** Handle the redirect back from Google. */
    public function callback(Request $request)
    {
        if (! $this->configured()) {
            return $this->unavailable($request);
        }

        $locale = $request->session()->pull('auth_locale', 'pt');

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (InvalidStateException) {
            return redirect()->route($locale === 'pt' ? 'login.pt' : 'login')
                ->withErrors(['email' => $this->message('expired', $locale)]);
        }

        $email = $googleUser->getEmail();
        if (! $email) {
            return redirect()->route($locale === 'pt' ? 'login.pt' : 'login')
                ->withErrors(['email' => $this->message('no_email', $locale)]);
        }

        $user = User::where('google_id', $googleUser->getId())->first()
            ?? User::where('email', $email)->first();

        if ($user) {
            // Link the Google account to an existing email-registered user.
            $user->forceFill([
                'google_id'         => $googleUser->getId(),
                'avatar_url'        => $googleUser->getAvatar() ?: $user->avatar_url,
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();
        } else {
            $user = User::create([
                'name'       => $googleUser->getName() ?: Str::before($email, '@'),
                'email'      => $email,
                'google_id'  => $googleUser->getId(),
                'avatar_url' => $googleUser->getAvatar(),
                'locale'     => $locale,
                'password'   => null,
            ]);
            $user->forceFill(['email_verified_at' => now()])->save();
        }

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->intended(route('invitations.index'));
    }

    private function configured(): bool
    {
        return filled(config('services.google.client_id'))
            && filled(config('services.google.client_secret'));
    }

    private function unavailable(Request $request)
    {
        $locale = $request->query('lang') === 'en' ? 'en' : 'pt';

        return redirect()->route($locale === 'pt' ? 'login.pt' : 'login')
            ->withErrors(['email' => $this->message('unavailable', $locale)]);
    }

    private function message(string $key, string $locale): string
    {
        $messages = [
            'expired' => [
                'pt' => 'A sessão com o Google expirou. Tente novamente.',
                'en' => 'The Google session expired. Please try again.',
            ],
            'no_email' => [
                'pt' => 'Não foi possível obter o seu e-mail do Google.',
                'en' => 'We could not read your email address from Google.',
            ],
            'unavailable' => [
                'pt' => 'O login com Google não está configurado neste momento. Use o seu e-mail e senha.',
                'en' => 'Google sign-in is not configured right now. Please use your email and password.',
            ],
        ];

        return $messages[$key][$locale];
    }
}
