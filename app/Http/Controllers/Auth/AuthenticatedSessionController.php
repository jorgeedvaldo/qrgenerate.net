<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\AuthSeo;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function create(string $locale = 'pt')
    {
        return view('auth.login', [
            'locale' => $locale,
            'seo'    => AuthSeo::for('login', $locale),
        ]);
    }

    public function store(Request $request, string $locale = 'pt')
    {
        $credentials = $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        // Accounts created through Google have no local password to check.
        $user = User::where('email', $credentials['email'])->first();
        if ($user && ! $user->hasPassword()) {
            throw ValidationException::withMessages([
                'email' => $locale === 'pt'
                    ? 'Esta conta foi criada com o Google. Entre com o botão "Continuar com Google".'
                    : 'This account was created with Google. Use the "Continue with Google" button.',
            ]);
        }

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw ValidationException::withMessages([
                'email' => $locale === 'pt'
                    ? 'Estas credenciais não correspondem aos nossos registos.'
                    : 'These credentials do not match our records.',
            ]);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('invitations.index'));
    }

    public function destroy(Request $request)
    {
        $locale = $request->user()?->locale ?? 'pt';

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to($locale === 'pt' ? '/pt' : '/');
    }
}
