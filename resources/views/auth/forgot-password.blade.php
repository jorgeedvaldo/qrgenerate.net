@extends('layouts.app')

@php
    $isPt = ($locale ?? 'pt') === 'pt';
    $t = $isPt ? [
        'heading' => 'Recuperar senha',
        'sub'     => 'Informe o seu e-mail e enviaremos um link para definir uma nova senha.',
        'email'   => 'E-mail',
        'submit'  => 'Enviar link',
        'back'    => 'Voltar para entrar',
    ] : [
        'heading' => 'Reset your password',
        'sub'     => 'Enter your email and we will send you a link to set a new password.',
        'email'   => 'Email',
        'submit'  => 'Send link',
        'back'    => 'Back to sign in',
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

        <form method="POST" action="{{ $isPt ? route('password.email.pt') : route('password.email') }}">
            @csrf
            <div class="form-group">
                <label for="email">{{ $t['email'] }}</label>
                <input id="email" type="email" name="email" class="form-control"
                       value="{{ old('email') }}" required autofocus autocomplete="email">
            </div>
            <button type="submit" class="btn-block-lg btn-primary-auth">{{ $t['submit'] }}</button>
        </form>

        <div class="auth-foot">
            <a href="{{ $isPt ? route('login.pt') : route('login') }}">{{ $t['back'] }}</a>
        </div>
    </div>
</div>
@endsection
