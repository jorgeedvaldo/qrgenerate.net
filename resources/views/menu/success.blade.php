@extends('layouts.app')

@push('styles')
<style>
    .success-wrap { max-width: 680px; margin: 40px auto 80px; }
    .success-hero { text-align: center; padding: 30px 20px 20px; }
    .success-card { background: #fff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,.1); overflow: hidden; margin-bottom: 20px; }
    .success-card-header { background: linear-gradient(135deg, #7b4397, #5b287a); color: #fff; padding: 14px 20px; font-weight: 700; font-size: 15px; }
    .success-card-body { padding: 24px; }
    .url-box { background: #f8f5fa; border: 2px solid #d1bfe0; border-radius: 10px; padding: 14px 16px; display: flex; align-items: center; gap: 10px; }
    .url-box span { flex: 1; font-family: monospace; font-size: 14px; color: #5b287a; word-break: break-all; }
    .btn-copy { background: #7b4397; color: #fff; border: none; border-radius: 8px; padding: 7px 14px; font-size: 13px; font-weight: 600; cursor: pointer; white-space: nowrap; transition: background .15s; }
    .btn-copy:hover { background: #5b287a; }
    .btn-copy.copied { background: #22c55e; }
    .warning-box { background: #fffbeb; border: 1.5px solid #f59e0b; border-radius: 10px; padding: 14px 16px; display: flex; gap: 10px; align-items: flex-start; }
    .qr-container { display: flex; justify-content: center; padding: 10px; }
    .action-links { display: flex; gap: 12px; flex-wrap: wrap; justify-content: center; margin-top: 20px; }
    .btn-action { display: inline-flex; align-items: center; gap: 6px; padding: 10px 20px; border-radius: 10px; font-weight: 600; font-size: 14px; text-decoration: none; transition: opacity .15s; border: none; cursor: pointer; }
    .btn-action:hover { opacity: .85; text-decoration: none; }
    .btn-visit { background: linear-gradient(135deg, #7b4397, #5b287a); color: #fff !important; }
    .btn-download { background: #f3f4f6; color: #374151 !important; border: 1.5px solid #d1d5db; }
</style>
@endpush

@section('content')
<div class="success-wrap">
    <div class="success-hero">
        <div style="font-size:56px; margin-bottom:12px;">🎉</div>
        <h1 style="font-size:26px; font-weight:800; color:#5b287a; margin:0 0 8px;">Cardápio criado com sucesso!</h1>
        <p style="color:#777; font-size:15px; margin:0;">Compartilhe o link ou o QR Code com seus clientes</p>
    </div>

    {{-- QR Code --}}
    <div class="success-card">
        <div class="success-card-header">📱 QR Code do Cardápio</div>
        <div class="success-card-body" style="text-align:center;">
            <p style="color:#666; font-size:13px; margin-bottom:16px;">Escaneie ou imprima este QR Code para seus clientes acessarem o cardápio</p>
            <div class="qr-container">
                <div id="qrcode"></div>
            </div>
            <div class="action-links">
                <a href="{{ $menu->publicUrl() }}" target="_blank" class="btn-action btn-visit">
                    🌐 Ver Cardápio
                </a>
                <button onclick="downloadQR()" class="btn-action btn-download">
                    ⬇️ Baixar QR Code (PNG)
                </button>
            </div>
        </div>
    </div>

    {{-- Link público --}}
    <div class="success-card">
        <div class="success-card-header">🔗 Link Público do Cardápio</div>
        <div class="success-card-body">
            <p style="color:#666; font-size:13px; margin-bottom:12px;">Compartilhe este link com seus clientes. Qualquer pessoa com o link pode visualizar o cardápio.</p>
            <div class="url-box">
                <span id="publicUrl">{{ $menu->publicUrl() }}</span>
                <button class="btn-copy" onclick="copyUrl('publicUrl', this)">Copiar</button>
            </div>
        </div>
    </div>

    {{-- Link de edição --}}
    @if($token)
    <div class="success-card">
        <div class="success-card-header">✏️ Link de Edição (exclusivo e secreto)</div>
        <div class="success-card-body">
            <div class="warning-box" style="margin-bottom:14px;">
                <div style="font-size:20px;">⚠️</div>
                <div>
                    <strong style="color:#92400e; font-size:13px;">Guarde este link com cuidado!</strong>
                    <p style="color:#78350f; font-size:12px; margin:4px 0 0;">Qualquer pessoa com este link poderá editar seu cardápio. Não o compartilhe publicamente. <strong>Não temos como recuperar este link se você perdê-lo.</strong></p>
                </div>
            </div>
            <div class="url-box">
                <span id="editUrl">{{ $menu->editUrl() }}</span>
                <button class="btn-copy" onclick="copyUrl('editUrl', this)">Copiar</button>
            </div>
        </div>
    </div>
    @endif

    {{-- Create another --}}
    <div style="text-align:center; margin-top:10px; display:flex; flex-wrap:wrap; gap:12px; justify-content:center;">
        <a href="{{ route('menu.create.pt') }}" style="color:#7b4397; font-size:14px;">🇧🇷 + Criar outro cardápio</a>
        <span style="color:#ccc;">|</span>
        <a href="{{ route('menu.create.en') }}" style="color:#7b4397; font-size:14px;">🇬🇧 + Create another menu</a>
    </div>
</div>
@endsection

@push('scripts')
<script>
const PUBLIC_URL = @json($menu->publicUrl());

window.addEventListener('load', function() {
    new QRCode(document.getElementById('qrcode'), {
        text: PUBLIC_URL,
        width: 240,
        height: 240,
        colorDark: '#1a1a1a',
        colorLight: '#ffffff',
        correctLevel: QRCode.CorrectLevel.M,
        drawer: 'canvas',
    });
});

function copyUrl(elementId, btn) {
    const text = document.getElementById(elementId).textContent;
    navigator.clipboard.writeText(text).then(() => {
        const original = btn.textContent;
        btn.textContent = '✓ Copiado!';
        btn.classList.add('copied');
        setTimeout(() => { btn.textContent = original; btn.classList.remove('copied'); }, 2000);
    });
}

function downloadQR() {
    const canvas = document.querySelector('#qrcode canvas');
    if (!canvas) return;
    const link = document.createElement('a');
    link.download = 'qrcode-cardapio.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
}
</script>
@endpush
