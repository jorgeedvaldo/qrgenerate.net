@extends('layouts.app')

@php
    $isPt = ($locale ?? 'pt') === 'pt';
    $t = $isPt ? [
        'title'    => 'Confirmações de presença',
        'confirmed'=> 'Pessoas confirmadas',
        'yes'      => 'Respostas sim',
        'no'       => 'Não podem ir',
        'guests'   => 'Na lista',
        'csv'      => 'Exportar CSV',
        'back'     => 'Voltar ao convite',
        'name'     => 'Nome',
        'contact'  => 'Contacto',
        'going'    => 'Presença',
        'party'    => 'Pessoas',
        'message'  => 'Recado',
        'when'     => 'Quando',
        'going_yes'=> 'Vai',
        'going_no' => 'Não vai',
        'empty'    => 'Ainda não há respostas. Partilhe o link do convite com os seus convidados.',
    ] : [
        'title'    => 'Replies',
        'confirmed'=> 'People confirmed',
        'yes'      => 'Yes replies',
        'no'       => 'Cannot come',
        'guests'   => 'On the list',
        'csv'      => 'Export CSV',
        'back'     => 'Back to the invitation',
        'name'     => 'Name',
        'contact'  => 'Contact',
        'going'    => 'Attending',
        'party'    => 'People',
        'message'  => 'Note',
        'when'     => 'When',
        'going_yes'=> 'Yes',
        'going_no' => 'No',
        'empty'    => 'No replies yet. Share the invitation link with your guests.',
    ];
    $seo = ['title' => $t['title'] . ' | QRGenerate', 'robots' => 'noindex, nofollow'];

    $yes = $rsvps->where('attending', true);
    $no  = $rsvps->where('attending', false);
    $people = $yes->sum(fn ($rsvp) => $rsvp->partySize());
@endphp

@include('invitations._dash')

@section('content')
<div class="dash">
    <div class="dash-head">
        <div>
            <h1>{{ $t['title'] }}</h1>
            <p>{{ $invitation->coupleNames() }} &middot; {{ $invitation->event_date->format('d/m/Y') }}</p>
        </div>
        <div class="inv-actions">
            <a href="{{ route('invitations.rsvps.csv', $invitation->slug) }}" class="btn-pill btn-outline">{{ $t['csv'] }}</a>
            <a href="{{ route('invitations.share', $invitation->slug) }}" class="btn-pill btn-outline">&larr; {{ $t['back'] }}</a>
        </div>
    </div>

    <div class="stat-grid" style="margin-bottom:18px;">
        <div class="stat"><div class="stat-num">{{ $people }}</div><div class="stat-lbl">{{ $t['confirmed'] }}</div></div>
        <div class="stat"><div class="stat-num">{{ $yes->count() }}</div><div class="stat-lbl">{{ $t['yes'] }}</div></div>
        <div class="stat"><div class="stat-num">{{ $no->count() }}</div><div class="stat-lbl">{{ $t['no'] }}</div></div>
        <div class="stat"><div class="stat-num">{{ $invitation->guests()->count() }}</div><div class="stat-lbl">{{ $t['guests'] }}</div></div>
    </div>

    <div class="panel-box">
        @if($rsvps->isEmpty())
            <p class="panel-hint" style="margin:10px 0 0;">{{ $t['empty'] }}</p>
        @else
            <div class="table-wrap">
                <table class="table-clean">
                    <thead>
                        <tr>
                            <th>{{ $t['name'] }}</th>
                            <th>{{ $t['contact'] }}</th>
                            <th>{{ $t['going'] }}</th>
                            <th>{{ $t['party'] }}</th>
                            <th>{{ $t['message'] }}</th>
                            <th>{{ $t['when'] }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($rsvps as $rsvp)
                            <tr>
                                <td>
                                    <strong>{{ $rsvp->name }}</strong>
                                    @if($rsvp->guest)
                                        <div class="inv-meta">{{ $rsvp->guest->name }}</div>
                                    @endif
                                    @if($rsvp->companion_names)
                                        <div class="inv-meta">+ {{ $rsvp->companion_names }}</div>
                                    @endif
                                </td>
                                <td style="font-size:13px;">
                                    @if($rsvp->email)<div>{{ $rsvp->email }}</div>@endif
                                    @if($rsvp->phone)<div>{{ $rsvp->phone }}</div>@endif
                                </td>
                                <td>
                                    <span class="pill {{ $rsvp->attending ? 'badge-yes' : 'badge-no' }}">
                                        {{ $rsvp->attending ? $t['going_yes'] : $t['going_no'] }}
                                    </span>
                                </td>
                                <td>{{ $rsvp->partySize() }}</td>
                                <td style="max-width:260px;font-size:13.5px;">{{ $rsvp->message }}</td>
                                <td style="font-size:13px;white-space:nowrap;">{{ $rsvp->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
