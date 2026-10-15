@extends('layouts.app')

@php
    $isPt = ($locale ?? 'pt') === 'pt';
    $t = $isPt ? [
        'heading'  => 'Definir nova senha',
        'sub'      => 'Escolha uma nova senha para a sua conta.',
        'email'    => 'E-mail',
        'password' => 'Nova senha',
        'confirm'  => 'Confirmar nova senha',
        'submit'   => 'Guardar nova senha',
    ] : [
        'heading'  => 'Choose a new password',
        'sub'      => 'Pick a new password for your account.',
        'email'    => 'Email',
        'password' => 'New password',
        'confirm'  => 'Confirm new password',
        'submit'   => 'Save new password',
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

        <form method="POST" action="{{ $isPt ? route('password.store.pt') : route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group">
                <label for="email">{{ $t['email'] }}</label>
                <input id="email" type="email" name="email" class="form-control"
                       value="{{ old('email', $email) }}" required autocomplete="email">
            </div>
            <div class="form-group">
                <label for="password">{{ $t['password'] }}</label>
                <input id="password" type="password" name="password" class="form-control"
                       required minlength="8" autofocus autocomplete="new-password">
            </div>
            <div class="form-group">
                <label for="password_confirmation">{{ $t['confirm'] }}</label>
                <input id="password_confirmation" type="password" name="password_confirmation"
                       class="form-control" required minlength="8" autocomplete="new-password">
            </div>
            <button type="submit" class="btn-block-lg btn-primary-auth">{{ $t['submit'] }}</button>
        </form>
    </div>
</div>
@endsection
