<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Support\AuthSeo;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    public function create(string $locale = 'pt')
    {
        return view('auth.register', [
            'locale' => $locale,
            'seo'    => AuthSeo::for('register', $locale),
        ]);
    }

    public function store(Request $request, string $locale = 'pt')
    {
        $data = $request->validate([
            'name'     => ['required', 'string', 'max:100'],
            'email'    => ['required', 'string', 'email', 'max:200', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        $user = User::create([
            'name'     => $data['name'],
            'email'    => $data['email'],
            'password' => $data['password'],
            'locale'   => $locale,
        ]);

        event(new Registered($user));

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()->intended(route('invitations.index'));
    }
}
