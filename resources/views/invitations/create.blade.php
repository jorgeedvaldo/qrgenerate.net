@extends('layouts.app')

@php
    $isPt = ($pageLocale ?? 'pt') === 'pt';
    $t = \App\Support\InvitationLabels::for($isPt ? 'pt' : 'en');
    $invitation = null;
    $seo = ['title' => $t['create_title'] . ' | QRGenerate', 'robots' => 'noindex, nofollow'];
@endphp

@include('invitations._dash')

@section('content')
<div class="dash">
    <div class="dash-head">
        <div>
            <h1>{{ $t['create_title'] }}</h1>
            <p>{{ $t['create_sub'] }}</p>
        </div>
        <a href="{{ route('invitations.index') }}" class="btn-pill btn-outline">&larr; {{ $t['back'] }}</a>
    </div>

    <form method="POST" action="{{ route('invitations.store') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="form_locale" value="{{ $isPt ? 'pt' : 'en' }}">

        @include('invitations._form')

        <button type="submit" class="btn-pill btn-main" style="width:100%;justify-content:center;padding:14px;font-size:16px;">
            {{ $t['submit_new'] }}
        </button>
    </form>
</div>
@endsection

