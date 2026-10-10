@extends('layouts.app')

@php
    $isPt = ($locale ?? 'pt') === 'pt';
    $t = $isPt ? [
        'heading'   => 'Criar a sua conta',
        'sub'       => 'Grátis. Depois basta montar o convite e partilhar o link.',
        'google'    => 'Criar conta com Google',
        'or'        => 'ou use o seu e-mail',
        'name'      => 'Nome',
        'name_ph'   => 'Ex: Aurora Quiari',
        'email'     => 'E-mail',
        'password'  => 'Senha',
        'pass_hint' => 'Mínimo de 8 caracteres.',
        'confirm'   => 'Confirmar senha',
        'submit'    => 'Criar conta',
        'has_acc'   => 'Já tem conta?',
        'login'     => 'Entrar',
        'legal'     => 'Ao criar conta você concorda com os nossos',
        'terms'     => 'Termos de Uso',
        'and'       => 'e a',
        'privacy'   => 'Política de Privacidade',
    ] : [
        'heading'   => 'Create your account',
        'sub'       => 'Free. Then build your invitation and share the link.',
        'google'    => 'Sign up with Google',
        'or'        => 'or use your email',
        'name'      => 'Name',
        'name_ph'   => 'e.g. Aurora Quiari',
        'email'     => 'Email',
        'password'  => 'Password',
        'pass_hint' => 'At least 8 characters.',
        'confirm'   => 'Confirm password',
        'submit'    => 'Create account',
        'has_acc'   => 'Already have an account?',
        'login'     => 'Sign in',
        'legal'     => 'By creating an account you agree to our',
        'terms'     => 'Terms of Use',
        'and'       => 'and',
        'privacy'   => 'Privacy Policy',
    ];
@endphp

@include('auth._card')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <h1>{{ $t['heading'] }}</h1>
        <p class="auth-sub">{{ $t['sub'] }}</p>

        @if($errors->any())
            <div class="alert alert-danger auth-alert">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @include('auth._google-button', ['locale' => $isPt ? 'pt' : 'en', 'label' => $t['google']])

        <div class="auth-divider">{{ $t['or'] }}</div>

        <form method="POST" action="{{ $isPt ? route('register.store.pt') : route('register.store') }}">
            @csrf
            <div class="form-group">
                <label for="name">{{ $t['name'] }}</label>
                <input id="name" type="text" name="name" class="form-control" placeholder="{{ $t['name_ph'] }}"
                       value="{{ old('name') }}" required maxlength="100" autocomplete="name" autofocus>
            </div>
            <div class="form-group">
                <label for="email">{{ $t['email'] }}</label>
                <input id="email" type="email" name="email" class="form-control"
                       value="{{ old('email') }}" required maxlength="200" autocomplete="email">
            </div>
            <div class="form-group">
                <label for="password">{{ $t['password'] }}</label>
                <input id="password" type="password" name="password" class="form-control"
                       required minlength="8" autocomplete="new-password">
                <span class="help-block" style="font-size:12px;margin:4px 0 0;">{{ $t['pass_hint'] }}</span>
            </div>
            <div class="form-group">
                <label for="password_confirmation">{{ $t['confirm'] }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="form-control" required minlength="8" autocomplete="new-password">
            </div>
            <button type="submit" class="btn-block-lg btn-primary-auth">{{ $t['submit'] }}</button>
        </form>

        <p class="auth-legal">
            {{ $t['legal'] }}
            <a href="{{ $isPt ? url('/pt/termos-de-uso') : url('/terms-of-use') }}">{{ $t['terms'] }}</a>
            {{ $t['and'] }}
            <a href="{{ $isPt ? url('/pt/politica-de-privacidade') : url('/privacy-policy') }}">{{ $t['privacy'] }}</a>.
        </p>

        <div class="auth-foot">
            {{ $t['has_acc'] }}
            <a href="{{ $isPt ? route('login.pt') : route('login') }}">{{ $t['login'] }}</a>
        </div>
    </div>
</div>
@endsection
