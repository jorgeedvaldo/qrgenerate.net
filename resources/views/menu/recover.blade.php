@extends('layouts.app')

@push('styles')
<style>
    .recover-wrap { max-width: 560px; margin: 60px auto 80px; }
    .recover-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,.1); overflow: hidden; }
    .recover-card-header { background: linear-gradient(135deg, #7b4397, #5b287a); color: #fff; padding: 14px 20px; font-weight: 700; font-size: 15px; }
    .recover-card-body { padding: 28px 24px; }
    .form-group label { font-weight: 600; color: #444; margin-bottom: 4px; display: block; font-size: 13px; }
    .form-control { border-radius: 8px !important; border: 1.5px solid #ddd !important; transition: border-color .2s; font-size: 14px; width: 100%; padding: 8px 12px; }
    .form-control:focus { border-color: #7b4397 !important; box-shadow: 0 0 0 3px rgba(123,67,151,.12) !important; outline: none; }
    .submit-btn { background: linear-gradient(135deg, #7b4397, #5b287a); color: #fff; border: none; border-radius: 10px; padding: 11px 28px; font-size: 15px; font-weight: 700; cursor: pointer; transition: opacity .2s; width: 100%; margin-top: 16px; }
    .submit-btn:hover { opacity: .9; }
    .sent-box { background: #dcfce7; border: 1px solid #86efac; color: #15803d; border-radius: 10px; padding: 14px 16px; font-size: 14px; font-weight: 600; margin-bottom: 20px; }
    .field-hint { font-size: 11px; color: #999; margin-top: 4px; }
    .lang-links { text-align: center; margin-top: 20px; font-size: 13px; }
    .lang-links a { color: #7b4397; }
</style>
@endpush

@section('content')
<div class="recover-wrap">
    <div style="text-align:center; padding: 0 0 28px;">
        <div style="font-size:44px; margin-bottom:10px;">🔑</div>
        <h1 style="font-size:24px; font-weight:800; color:#5b287a; margin:0 0 8px;">Recuperar Link de Edição</h1>
        <p style="color:#777; font-size:14px; margin:0;">
            Informe o e-mail de recuperação cadastrado e enviaremos o link de edição do seu cardápio.
        </p>
    </div>

    @if(session('sent'))
    <div class="sent-box">
        ✅ Se encontrarmos um cardápio vinculado a este e-mail, enviaremos o link de edição em instantes. Verifique também a pasta de spam.
    </div>
    @endif

    <div class="recover-card">
        <div class="recover-card-header">📧 Recuperar por E-mail</div>
        <div class="recover-card-body">
            @if($errors->any())
            <div class="alert alert-danger" style="border-radius:8px; margin-bottom:16px;">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
            @endif

            <form action="{{ route('menu.recover.send.pt') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>E-mail de recuperação</label>
                    <input type="email" name="email" class="form-control" placeholder="seuemail@exemplo.com" value="{{ old('email') }}" required autofocus>
                    <div class="field-hint">Use o mesmo e-mail que você informou ao criar o cardápio como "e-mail de recuperação".</div>
                </div>
                <button type="submit" class="submit-btn">Enviar link de edição</button>
            </form>
        </div>
    </div>

    <div class="lang-links">
        <a href="{{ route('menu.create.pt') }}">🇧🇷 Criar novo cardápio</a>
        &nbsp;·&nbsp;
        <a href="{{ route('menu.create.en') }}">🇬🇧 Create a new menu</a>
    </div>
</div>
@endsection
