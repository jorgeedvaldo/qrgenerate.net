@extends('layouts.app')

@php
    $isPt = ($pageLocale ?? 'pt') === 'pt';
    $t = \App\Support\InvitationLabels::for($isPt ? 'pt' : 'en');
    $seo = ['title' => $t['edit_title'] . ' | QRGenerate', 'robots' => 'noindex, nofollow'];
@endphp

@include('invitations._dash')

@section('content')
<div class="dash">
    <div class="dash-head">
        <div>
            <h1>{{ $t['edit_title'] }}</h1>
            <p>{{ $t['edit_sub'] }}</p>
        </div>
        <div class="inv-actions">
            <a href="{{ route('invitations.index') }}" class="btn-pill btn-outline">&larr; {{ $t['back'] }}</a>
            <a href="{{ $invitation->publicUrl() }}" target="_blank" rel="noopener" class="btn-pill btn-outline">{{ $t['view'] }}</a>
        </div>
    </div>

    @if(session('status'))
        <div class="alert alert-success" style="border-radius:10px;">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('invitations.update', $invitation->slug) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <input type="hidden" name="form_locale" value="{{ $isPt ? 'pt' : 'en' }}">

        @include('invitations._form')

        <button type="submit" class="btn-pill btn-main" style="width:100%;justify-content:center;padding:14px;font-size:16px;">
            {{ $t['submit_edit'] }}
        </button>
    </form>

    <form method="POST" action="{{ route('invitations.destroy', $invitation->slug) }}"
          onsubmit="return confirm(@json($t['delete_ask']));" style="margin-top:22px;text-align:center;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-pill btn-danger-soft">{{ $t['delete'] }}</button>
    </form>
</div>
@endsection

