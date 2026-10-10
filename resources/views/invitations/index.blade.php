@extends('layouts.app')

@php
    $isPt = ($locale ?? 'pt') === 'pt';
    $t = $isPt ? [
        'title'    => 'Meus convites',
        'sub'      => 'Crie, edite e acompanhe as confirmações dos seus convites.',
        'new'      => 'Criar novo convite',
        'empty_h'  => 'Ainda não tem convites',
        'empty_p'  => 'Crie o seu primeiro convite de casamento ou noivado — leva poucos minutos.',
        'open'     => 'Ver convite',
        'edit'     => 'Editar',
        'share'    => 'Partilhar',
        'guests'   => 'Convidados',
        'rsvps'    => 'Confirmações',
        'confirmed'=> 'pessoas confirmadas',
        'guest_n'  => 'convidados',
        'views'    => 'visitas',
        'wedding'  => 'Casamento',
        'engage'   => 'Noivado',
        'draft'    => 'Oculto',
    ] : [
        'title'    => 'My invitations',
        'sub'      => 'Create, edit and track the replies to your invitations.',
        'new'      => 'Create new invitation',
        'empty_h'  => 'No invitations yet',
        'empty_p'  => 'Create your first wedding or engagement invitation — it only takes a few minutes.',
        'open'     => 'View invitation',
        'edit'     => 'Edit',
        'share'    => 'Share',
        'guests'   => 'Guests',
        'rsvps'    => 'Replies',
        'confirmed'=> 'people confirmed',
        'guest_n'  => 'guests',
        'views'    => 'views',
        'wedding'  => 'Wedding',
        'engage'   => 'Engagement',
        'draft'    => 'Hidden',
    ];
    $seo = ['title' => $t['title'] . ' | QRGenerate', 'robots' => 'noindex, nofollow'];
@endphp

@include('invitations._dash')

@section('content')
<div class="dash">
    <div class="dash-head">
        <div>
            <h1>{{ $t['title'] }}</h1>
            <p>{{ $t['sub'] }}</p>
        </div>
        <a href="{{ route('invitations.create') }}" class="btn-pill btn-main">+ {{ $t['new'] }}</a>
    </div>

    @if(session('status'))
        <div class="alert alert-success" style="border-radius:10px;">{{ session('status') }}</div>
    @endif

    @forelse($invitations as $invitation)
        <div class="inv-card">
            @if($invitation->cover_url)
                <img class="inv-thumb" src="{{ $invitation->cover_url }}" alt="">
            @else
                <div class="inv-thumb">{{ $invitation->type === 'wedding' ? '💍' : '💐' }}</div>
            @endif

            <div class="inv-body">
                <h3>{{ $invitation->coupleNames() }}</h3>
                <p class="inv-meta">
                    <span class="pill">{{ $invitation->type === 'wedding' ? $t['wedding'] : $t['engage'] }}</span>
                    @unless($invitation->is_active)
                        <span class="pill badge-no">{{ $t['draft'] }}</span>
                    @endunless
                    {{ $invitation->event_date->format('d/m/Y') }}
                </p>
                <div class="inv-stats">
                    <span><strong>{{ $invitation->confirmed_rsvps + (int) $invitation->confirmed_companions }}</strong> {{ $t['confirmed'] }}</span>
                    <span><strong>{{ $invitation->guests_count }}</strong> {{ $t['guest_n'] }}</span>
                    <span><strong>{{ $invitation->view_count }}</strong> {{ $t['views'] }}</span>
                </div>
            </div>

            <div class="inv-actions">
                <a href="{{ $invitation->publicUrl() }}" target="_blank" rel="noopener" class="btn-pill btn-outline">{{ $t['open'] }}</a>
                <a href="{{ route('invitations.edit', $invitation->slug) }}" class="btn-pill btn-outline">{{ $t['edit'] }}</a>
                <a href="{{ route('invitations.guests', $invitation->slug) }}" class="btn-pill btn-outline">{{ $t['guests'] }}</a>
                <a href="{{ route('invitations.rsvps', $invitation->slug) }}" class="btn-pill btn-outline">{{ $t['rsvps'] }}</a>
                <a href="{{ route('invitations.share', $invitation->slug) }}" class="btn-pill btn-main">{{ $t['share'] }}</a>
            </div>
        </div>
    @empty
        <div class="panel-box empty-state">
            <span class="emoji">💍</span>
            <h2>{{ $t['empty_h'] }}</h2>
            <p>{{ $t['empty_p'] }}</p>
            <a href="{{ route('invitations.create') }}" class="btn-pill btn-main" style="margin-top:14px;">+ {{ $t['new'] }}</a>
        </div>
    @endforelse
</div>
@endsection
