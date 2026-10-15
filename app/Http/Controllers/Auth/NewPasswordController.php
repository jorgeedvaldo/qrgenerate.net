<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\AuthSeo;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;

class NewPasswordController extends Controller
{
    public function create(Request $request, string $token, string $locale = 'pt')
    {
        return view('auth.reset-password', [
            'locale' => $locale,
            'token'  => $token,
            'email'  => $request->query('email'),
            'seo'    => AuthSeo::for('reset', $locale),
        ]);
    }

    public function store(Request $request, string $locale = 'pt')
    {
        $request->validate([
            'token'    => ['required'],
            'email'    => ['required', 'email'],
            'password' => ['required', 'confirmed', PasswordRule::min(8)],
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password'       => $request->password,
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status !== Password::PasswordReset) {
            throw ValidationException::withMessages([
                'email' => $locale === 'pt'
                    ? 'Este link de redefinição é inválido ou expirou.'
                    : 'This password reset link is invalid or has expired.',
            ]);
        }

        return redirect()->route($locale === 'pt' ? 'login.pt' : 'login')
            ->with('status', $locale === 'pt'
                ? 'Senha redefinida. Já pode entrar.'
                : 'Your password has been reset. You can sign in now.');
    }
}
