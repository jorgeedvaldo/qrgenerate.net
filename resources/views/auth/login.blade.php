@extends('layouts.app')

@php
    $isPt = ($locale ?? 'pt') === 'pt';
    $t = $isPt ? [
        'heading'   => 'Entrar na sua conta',
        'sub'       => 'Acesse os seus convites e veja quem confirmou presença.',
        'google'    => 'Continuar com Google',
        'or'        => 'ou entre com e-mail',
        'email'     => 'E-mail',
        'password'  => 'Senha',
        'remember'  => 'Manter-me ligado',
        'forgot'    => 'Esqueceu a senha?',
        'submit'    => 'Entrar',
        'no_acc'    => 'Ainda não tem conta?',
        'create'    => 'Criar conta grátis',
    ] : [
        'heading'   => 'Sign in to your account',
        'sub'       => 'Manage your invitations and see who has replied.',
        'google'    => 'Continue with Google',
        'or'        => 'or sign in with email',
        'email'     => 'Email',
        'password'  => 'Password',
        'remember'  => 'Keep me signed in',
        'forgot'    => 'Forgot your password?',
        'submit'    => 'Sign in',
        'no_acc'    => "Don't have an account?",
        'create'    => 'Create a free account',
    ];
@endphp

@include('auth._card')

@section('content')
<div class="auth-wrap">
    <div class="auth-card">
        <h1>{{ $t['heading'] }}</h1>
        <p class="auth-sub">{{ $t['sub'] }}</p>

        @if(session('status'))
            <div class="alert alert-success auth-alert">{{ session('status') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger auth-alert">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @include('auth._google-button', ['locale' => $isPt ? 'pt' : 'en', 'label' => $t['google']])

        <div class="auth-divider">{{ $t['or'] }}</div>

        <form method="POST" action="{{ $isPt ? route('login.store.pt') : route('login.store') }}">
            @csrf
            <div class="form-group">
                <label for="email">{{ $t['email'] }}</label>
                <input id="email" type="email" name="email" class="form-control"
                       value="{{ old('email') }}" required autocomplete="email" autofocus>
            </div>
            <div class="form-group">
                <label for="password">{{ $t['password'] }}</label>
                <input id="password" type="password" name="password" class="form-control"
                       required autocomplete="current-password">
            </div>
            <div class="checkbox" style="margin-bottom:18px;">
                <label style="font-weight:400;font-size:13px;">
                    <input type="checkbox" name="remember" value="1"> {{ $t['remember'] }}
                </label>
            </div>
            <button type="submit" class="btn-block-lg btn-primary-auth">{{ $t['submit'] }}</button>
        </form>

        <div class="auth-foot">
            <a href="{{ $isPt ? route('password.request.pt') : route('password.request') }}">{{ $t['forgot'] }}</a>
        </div>
        <div class="auth-foot">
            {{ $t['no_acc'] }}
            <a href="{{ $isPt ? route('register.pt') : route('register') }}">{{ $t['create'] }}</a>
        </div>
    </div>
</div>
@endsection
