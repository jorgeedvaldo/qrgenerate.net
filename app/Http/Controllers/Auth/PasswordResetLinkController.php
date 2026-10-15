<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\AuthSeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class PasswordResetLinkController extends Controller
{
    public function create(string $locale = 'pt')
    {
        return view('auth.forgot-password', [
            'locale' => $locale,
            'seo'    => AuthSeo::for('forgot', $locale),
        ]);
    }

    public function store(Request $request, string $locale = 'pt')
    {
        $request->validate(['email' => ['required', 'email']]);

        Password::sendResetLink($request->only('email'));

        // Always report success so the form cannot be used to probe for accounts.
        return back()->with('status', $locale === 'pt'
            ? 'Se existir uma conta com este e-mail, enviámos um link para redefinir a senha.'
            : 'If an account exists for that email, we have sent a password reset link.');
    }
}
