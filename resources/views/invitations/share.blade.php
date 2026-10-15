@extends('layouts.app')

@php
    $isPt = ($locale ?? 'pt') === 'pt';
    $t = $isPt ? [
        'title'   => 'Convite pronto!',
        'sub'     => 'Partilhe o link ou o QR Code com os seus convidados.',
        'link'    => 'Link do convite',
        'copy'    => 'Copiar',
        'copied'  => 'Copiado!',
        'qr'      => 'QR Code',
        'qr_hint' => 'Imprima no convite em papel ou mostre no telefone.',
        'download'=> 'Baixar PNG',
        'print'   => 'Imprimir',
        'wa'      => 'Enviar no WhatsApp',
        'open'    => 'Abrir convite',
        'next'    => 'Próximos passos',
        'n1'      => 'Adicione os seus convidados para gerar um link personalizado para cada um.',
        'n2'      => 'Acompanhe quem confirmou presença.',
        'n3'      => 'Volte ao editor sempre que quiser mudar algo.',
        'guests'  => 'Adicionar convidados',
        'rsvps'   => 'Ver confirmações',
        'edit'    => 'Editar convite',
        'back'    => 'Meus convites',
        'perso'   => 'Link personalizado',
        'perso_hint' => 'Acrescente ?c=Nome ao link para saudar o convidado pelo nome — ou gere um link por convidado na página de convidados.',
    ] : [
        'title'   => 'Your invitation is ready!',
        'sub'     => 'Share the link or the QR code with your guests.',
        'link'    => 'Invitation link',
        'copy'    => 'Copy',
        'copied'  => 'Copied!',
        'qr'      => 'QR code',
        'qr_hint' => 'Print it on a paper invite or show it on your phone.',
        'download'=> 'Download PNG',
        'print'   => 'Print',
        'wa'      => 'Send on WhatsApp',
        'open'    => 'Open invitation',
        'next'    => 'Next steps',
        'n1'      => 'Add your guests to get a personalised link for each of them.',
        'n2'      => 'Track who has confirmed.',
        'n3'      => 'Come back to the editor whenever you want to change something.',
        'guests'  => 'Add guests',
        'rsvps'   => 'See replies',
        'edit'    => 'Edit invitation',
        'back'    => 'My invitations',
        'perso'   => 'Personalised link',
        'perso_hint' => 'Append ?c=Name to greet a guest by name — or generate one link per guest on the guests page.',
    ];
    $seo = ['title' => $t['title'] . ' | QRGenerate', 'robots' => 'noindex, nofollow'];
    $publicUrl = $invitation->publicUrl();
@endphp

@include('invitations._dash')

@section('content')
<div class="dash" style="max-width:720px;">
    <div class="panel-box" style="text-align:center;">
        <div style="font-size:46px;line-height:1;">{{ $invitation->type === 'wedding' ? '💍' : '💐' }}</div>
        <h1 style="font-size:25px;color:#5b287a;margin:12px 0 4px;font-weight:700;">{{ $t['title'] }}</h1>
        <p style="color:#6b7280;font-size:14.5px;margin:0 0 20px;">{{ $t['sub'] }}</p>

        <label style="text-align:left;">{{ $t['link'] }}</label>
        <div class="link-box">
            <code id="inviteLink">{{ $publicUrl }}</code>
            <button type="button" class="btn-pill btn-outline" style="margin-left:auto;flex:0 0 auto;padding:6px 12px;"
                    onclick="copyInvite(this)">{{ $t['copy'] }}</button>
        </div>

        <div style="margin:22px 0 10px;">
            <label>{{ $t['qr'] }}</label>
            <div id="qrcode" style="display:inline-block;background:#fff;padding:12px;border:1px solid #e5e7eb;border-radius:10px;"></div>
            <p class="help-small">{{ $t['qr_hint'] }}</p>
        </div>

        <div class="inv-actions" style="justify-content:center;margin-top:12px;">
            <button type="button" class="btn-pill btn-outline" onclick="downloadQR()">{{ $t['download'] }}</button>
            <button type="button" class="btn-pill btn-outline" onclick="window.print()">{{ $t['print'] }}</button>
            <a class="btn-pill btn-outline" target="_blank" rel="noopener"
               href="https://wa.me/?text={{ urlencode($invitation->coupleNames() . ' — ' . $publicUrl) }}">{{ $t['wa'] }}</a>
            <a class="btn-pill btn-main" href="{{ $publicUrl }}" target="_blank" rel="noopener">{{ $t['open'] }}</a>
        </div>
    </div>

    <div class="panel-box">
        <h2>{{ $t['perso'] }}</h2>
        <p class="panel-hint">{{ $t['perso_hint'] }}</p>
        <div class="link-box"><code>{{ $publicUrl }}?c={{ $isPt ? 'Fam%C3%ADlia%20Silva' : 'The%20Smiths' }}</code></div>
    </div>

    <div class="panel-box">
        <h2>{{ $t['next'] }}</h2>
        <ol style="padding-left:20px;color:#4b5563;font-size:14.5px;line-height:1.8;margin:10px 0 18px;">
            <li>{{ $t['n1'] }}</li>
            <li>{{ $t['n2'] }}</li>
            <li>{{ $t['n3'] }}</li>
        </ol>
        <div class="inv-actions">
            <a href="{{ route('invitations.guests', $invitation->slug) }}" class="btn-pill btn-main">{{ $t['guests'] }}</a>
            <a href="{{ route('invitations.rsvps', $invitation->slug) }}" class="btn-pill btn-outline">{{ $t['rsvps'] }}</a>
            <a href="{{ route('invitations.edit', $invitation->slug) }}" class="btn-pill btn-outline">{{ $t['edit'] }}</a>
            <a href="{{ route('invitations.index') }}" class="btn-pill btn-outline">{{ $t['back'] }}</a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
var INVITE_URL = @json($publicUrl);
var INVITE_SLUG = @json($invitation->slug);

new QRCode(document.getElementById('qrcode'), {
    text: INVITE_URL,
    width: 220,
    height: 220,
    colorDark: @json($invitation->accent_color),
    colorLight: '#ffffff',
    correctLevel: QRCode.CorrectLevel.M,
    drawer: 'canvas'
});

function copyInvite(button) {
    var label = button.textContent;
    var done = function () {
        button.textContent = @json($t['copied']);
        setTimeout(function () { button.textContent = label; }, 1800);
    };

    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(INVITE_URL).then(done);
        return;
    }

    var ta = document.createElement('textarea');
    ta.value = INVITE_URL;
    ta.style.position = 'fixed';
    ta.style.opacity = '0';
    document.body.appendChild(ta);
    ta.select();
    try { document.execCommand('copy'); done(); } catch (e) { /* ignore */ }
    document.body.removeChild(ta);
}

function downloadQR() {
    var canvas = document.querySelector('#qrcode canvas');
    if (!canvas) return;
    var link = document.createElement('a');
    link.download = 'qrcode-convite-' + INVITE_SLUG + '.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
}
</script>
@endpush
