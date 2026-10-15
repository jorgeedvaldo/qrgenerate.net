@extends('layouts.app')

@php
    $isPt = ($locale ?? 'pt') === 'pt';
    $t = $isPt ? [
        'title'  => 'Convidados',
        'sub'    => 'Cada convidado recebe um link que o saúda pelo nome.',
        'add'    => 'Adicionar convidado',
        'name'   => 'Nome',
        'name_ph'=> 'Ex: Família Silva',
        'email'  => 'E-mail (opcional)',
        'phone'  => 'Telefone (opcional)',
        'group'  => 'Grupo (opcional)',
        'group_ph' => 'Ex: Família da noiva',
        'comp'   => 'Acompanhantes',
        'save'   => 'Adicionar',
        'bulk'   => 'Adicionar vários de uma vez',
        'bulk_hint' => 'Um nome por linha.',
        'bulk_save' => 'Adicionar lista',
        'list'   => 'Lista de convidados',
        'link'   => 'Link personalizado',
        'copy'   => 'Copiar',
        'copied' => 'Copiado!',
        'wa'     => 'WhatsApp',
        'remove' => 'Remover',
        'remove_ask' => 'Remover este convidado da lista?',
        'opened' => 'Abriu o convite',
        'replied'=> 'Respondeu',
        'pending'=> 'Sem resposta',
        'empty'  => 'Ainda não há convidados nesta lista. Adicione o primeiro acima.',
        'back'   => 'Voltar ao convite',
        'total'  => 'convidados na lista',
    ] : [
        'title'  => 'Guests',
        'sub'    => 'Each guest gets a link that greets them by name.',
        'add'    => 'Add a guest',
        'name'   => 'Name',
        'name_ph'=> 'e.g. The Smith family',
        'email'  => 'Email (optional)',
        'phone'  => 'Phone (optional)',
        'group'  => 'Group (optional)',
        'group_ph' => "e.g. Bride's family",
        'comp'   => 'Companions',
        'save'   => 'Add',
        'bulk'   => 'Add several at once',
        'bulk_hint' => 'One name per line.',
        'bulk_save' => 'Add list',
        'list'   => 'Guest list',
        'link'   => 'Personalised link',
        'copy'   => 'Copy',
        'copied' => 'Copied!',
        'wa'     => 'WhatsApp',
        'remove' => 'Remove',
        'remove_ask' => 'Remove this guest from the list?',
        'opened' => 'Opened the invitation',
        'replied'=> 'Replied',
        'pending'=> 'No reply yet',
        'empty'  => 'No guests on this list yet. Add the first one above.',
        'back'   => 'Back to the invitation',
        'total'  => 'guests on the list',
    ];
    $seo = ['title' => $t['title'] . ' | QRGenerate', 'robots' => 'noindex, nofollow'];
@endphp

@include('invitations._dash')

@section('content')
<div class="dash">
    <div class="dash-head">
        <div>
            <h1>{{ $t['title'] }}</h1>
            <p>{{ $invitation->coupleNames() }} &middot; {{ $guests->count() }} {{ $t['total'] }}</p>
        </div>
        <a href="{{ route('invitations.share', $invitation->slug) }}" class="btn-pill btn-outline">&larr; {{ $t['back'] }}</a>
    </div>

    @if(session('status'))
        <div class="alert alert-success" style="border-radius:10px;">{{ session('status') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger" style="border-radius:10px;">
            @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
        </div>
    @endif

    <div class="panel-box">
        <h2>{{ $t['add'] }}</h2>
        <p class="panel-hint">{{ $t['sub'] }}</p>
        <form method="POST" action="{{ route('invitations.guests.store', $invitation->slug) }}">
            @csrf
            <div class="grid-2">
                <div class="form-group">
                    <label>{{ $t['name'] }} *</label>
                    <input type="text" name="name" class="form-control" required maxlength="120" placeholder="{{ $t['name_ph'] }}">
                </div>
                <div class="form-group">
                    <label>{{ $t['group'] }}</label>
                    <input type="text" name="group_label" class="form-control" maxlength="60" placeholder="{{ $t['group_ph'] }}">
                </div>
            </div>
            <div class="grid-3">
                <div class="form-group">
                    <label>{{ $t['email'] }}</label>
                    <input type="email" name="email" class="form-control" maxlength="200">
                </div>
                <div class="form-group">
                    <label>{{ $t['phone'] }}</label>
                    <input type="text" name="phone" class="form-control" maxlength="30">
                </div>
                <div class="form-group">
                    <label>{{ $t['comp'] }}</label>
                    <input type="number" name="max_companions" class="form-control" min="0" max="20" value="0">
                </div>
            </div>
            <button type="submit" class="btn-pill btn-main">{{ $t['save'] }}</button>
        </form>
    </div>

    <div class="panel-box">
        <h2>{{ $t['bulk'] }}</h2>
        <p class="panel-hint">{{ $t['bulk_hint'] }}</p>
        <form method="POST" action="{{ route('invitations.guests.bulk', $invitation->slug) }}">
            @csrf
            <div class="form-group">
                <textarea name="names" class="form-control" rows="5" maxlength="8000"
                          placeholder="{{ $isPt ? "Família Silva\nTia Joana\nOnésimo e Edvaldo" : "The Smith family\nAunt Jane\nJohn and Mary" }}"></textarea>
            </div>
            <div class="form-group">
                <label>{{ $t['group'] }}</label>
                <input type="text" name="group_label" class="form-control" maxlength="60" placeholder="{{ $t['group_ph'] }}">
            </div>
            <button type="submit" class="btn-pill btn-outline">{{ $t['bulk_save'] }}</button>
        </form>
    </div>

    <div class="panel-box">
        <h2>{{ $t['list'] }}</h2>
        @if($guests->isEmpty())
            <p class="panel-hint" style="margin:14px 0 0;">{{ $t['empty'] }}</p>
        @else
            <div class="table-wrap">
                <table class="table-clean">
                    <thead>
                        <tr>
                            <th>{{ $t['name'] }}</th>
                            <th>{{ $t['link'] }}</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($guests as $guest)
                            @php $guestUrl = $invitation->publicUrl($guest->code); @endphp
                            <tr>
                                <td>
                                    <strong>{{ $guest->name }}</strong>
                                    @if($guest->group_label)
                                        <span class="pill">{{ $guest->group_label }}</span>
                                    @endif
                                    <div class="inv-meta" style="margin-top:4px;">
                                        @if($guest->rsvps_count > 0)
                                            <span class="pill badge-yes">{{ $t['replied'] }}</span>
                                        @elseif($guest->opened_at)
                                            <span class="pill">{{ $t['opened'] }}</span>
                                        @else
                                            <span class="pill">{{ $t['pending'] }}</span>
                                        @endif
                                        @if($guest->max_companions > 0)
                                            &middot; +{{ $guest->max_companions }}
                                        @endif
                                    </div>
                                </td>
                                <td style="min-width:240px;">
                                    <div class="link-box">
                                        <code data-guest-link="{{ $guestUrl }}">{{ $guestUrl }}</code>
                                    </div>
                                </td>
                                <td style="white-space:nowrap;">
                                    <button type="button" class="btn-pill btn-outline" style="padding:6px 12px;"
                                            onclick="copyGuestLink(this, @json($guestUrl))">{{ $t['copy'] }}</button>
                                    @if($guest->phone)
                                        <a class="btn-pill btn-outline" style="padding:6px 12px;" target="_blank" rel="noopener"
                                           href="https://wa.me/{{ preg_replace('/\D/', '', $guest->phone) }}?text={{ urlencode($guestUrl) }}">{{ $t['wa'] }}</a>
                                    @endif
                                    <form method="POST" style="display:inline;"
                                          action="{{ route('invitations.guests.destroy', [$invitation->slug, $guest->id]) }}"
                                          onsubmit="return confirm(@json($t['remove_ask']));">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-pill btn-danger-soft" style="padding:6px 12px;">{{ $t['remove'] }}</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyGuestLink(button, url) {
    var label = button.textContent;
    var done = function () {
        button.textContent = @json($t['copied']);
        setTimeout(function () { button.textContent = label; }, 1800);
    };

    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(url).then(done);
        return;
    }

    var ta = document.createElement('textarea');
    ta.value = url;
    ta.style.position = 'fixed';
    ta.style.opacity = '0';
    document.body.appendChild(ta);
    ta.select();
    try { document.execCommand('copy'); done(); } catch (e) { /* ignore */ }
    document.body.removeChild(ta);
}
</script>
@endpush
