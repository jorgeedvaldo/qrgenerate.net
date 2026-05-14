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
    .action-links { display: flex; gap: 10px; flex-wrap: wrap; justify-content: center; margin-top: 20px; }
    .btn-action { display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; border-radius: 10px; font-weight: 600; font-size: 13px; text-decoration: none; transition: opacity .15s; border: none; cursor: pointer; }
    .btn-action:hover { opacity: .85; text-decoration: none; }
    .btn-visit { background: linear-gradient(135deg, #7b4397, #5b287a); color: #fff !important; }
    .btn-download { background: #f3f4f6; color: #374151 !important; border: 1.5px solid #d1d5db; }
    .print-text-wrap { margin: 16px 0 0; }
    .print-text-wrap label { font-size: 12px; color: #666; font-weight: 600; display: block; margin-bottom: 5px; }
    .print-text-input { width: 100%; border: 1.5px solid #ddd; border-radius: 8px; padding: 8px 12px; font-size: 13px; outline: none; transition: border-color .2s; }
    .print-text-input:focus { border-color: #7b4397; }
    @media print {
        body * { visibility: hidden !important; }
        #printArea, #printArea * { visibility: visible !important; }
        #printArea { position: fixed; inset: 0; display: flex; flex-direction: column; align-items: center; justify-content: center; background: #fff; }
    }
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

            {{-- Print area (hidden except during print) --}}
            <div id="printArea" style="text-align:center;">
                <div id="printRestaurantName" style="font-family:Arial,sans-serif; font-size:22px; font-weight:800; color:#1a1a1a; margin-bottom:10px;">{{ $menu->restaurant_name }}</div>
                <div id="qrcode" style="display:inline-block;"></div>
                <div id="printCustomText" style="font-family:Arial,sans-serif; font-size:14px; color:#555; margin-top:10px;"></div>
                <div style="font-family:monospace; font-size:11px; color:#888; margin-top:6px; word-break:break-all;">{{ $menu->publicUrl() }}</div>
            </div>

            {{-- Custom print text --}}
            <div class="print-text-wrap">
                <label for="qrCustomText">Texto personalizado para impressão / PDF</label>
                <input type="text" id="qrCustomText" class="print-text-input" placeholder="Ex: Escaneie para ver nosso cardápio · Mesa 5 · Wi-Fi: MinhaRede" maxlength="200" oninput="document.getElementById('printCustomText').textContent=this.value">
            </div>

            <div class="action-links">
                <a href="{{ $menu->publicUrl() }}" target="_blank" class="btn-action btn-visit">
                    🌐 Ver Cardápio
                </a>
                <button onclick="downloadQR()" class="btn-action btn-download">
                    ⬇️ PNG
                </button>
                <button onclick="printQR()" class="btn-action btn-download">
                    🖨️ Imprimir
                </button>
                <button onclick="saveAsPdf()" class="btn-action btn-download">
                    📄 PDF
                </button>
                <button onclick="saveAsDocx()" class="btn-action btn-download">
                    📝 DOCX
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
                    <p style="color:#78350f; font-size:12px; margin:4px 0 0;">Qualquer pessoa com este link poderá editar seu cardápio. Não o compartilhe publicamente.</p>
                    @if($menu->recovery_email)
                    <p style="color:#78350f; font-size:12px; margin:6px 0 0;">📧 Uma cópia do link de edição foi enviada para <strong>{{ $menu->recovery_email }}</strong>. Você também pode recuperá-lo pelo <a href="{{ route('menu.recover.pt') }}" style="color:#92400e;">link de recuperação</a>.</p>
                    @else
                    <p style="color:#78350f; font-size:12px; margin:4px 0 0;"><strong>Não temos como recuperar este link se você perdê-lo.</strong> Considere salvar um e-mail de recuperação ao editar o cardápio.</p>
                    @endif
                </div>
            </div>
            <div class="url-box">
                <span id="editUrl">{{ $menu->editUrl() }}</span>
                <button class="btn-copy" onclick="copyUrl('editUrl', this)">Copiar</button>
            </div>
        </div>
    </div>
    @endif

    {{-- Recovery email confirmation --}}
    @if($menu->recovery_email)
    <div class="success-card">
        <div class="success-card-header">📧 Link enviado por e-mail</div>
        <div class="success-card-body">
            <p style="color:#555; font-size:13px; margin:0;">O link de edição foi enviado para <strong>{{ $menu->recovery_email }}</strong>. Se perdê-lo no futuro, <a href="{{ route('menu.recover.pt') }}" style="color:#7b4397;">solicite novamente aqui</a>.</p>
        </div>
    </div>
    @else
    <div style="background:#faf8fc; border:1px solid #e4d9f0; border-radius:10px; padding:12px 16px; font-size:13px; color:#666; text-align:center; margin-bottom:10px;">
        💡 Não cadastrou e-mail de recuperação? <a href="{{ route('menu.recover.pt') }}" style="color:#7b4397;">Solicite o link por e-mail</a> se o perder.
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

const RESTAURANT_NAME = @json($menu->restaurant_name);
const PUBLIC_URL_FULL = @json($menu->publicUrl());

function getQRCanvas() {
    return document.querySelector('#qrcode canvas');
}

function downloadQR() {
    const canvas = getQRCanvas();
    if (!canvas) return;
    const link = document.createElement('a');
    link.download = 'qrcode-cardapio.png';
    link.href = canvas.toDataURL('image/png');
    link.click();
}

function printQR() {
    window.print();
}

function saveAsPdf() {
    // Uses browser print-to-PDF (most reliable cross-platform approach)
    window.print();
}

function saveAsDocx() {
    const canvas = getQRCanvas();
    if (!canvas) return;
    const imgData = canvas.toDataURL('image/png');
    const customText = document.getElementById('qrCustomText').value;

    // Word-HTML format (opens natively in Microsoft Word / LibreOffice)
    const html = `<html xmlns:o='urn:schemas-microsoft-com:office:office'
xmlns:w='urn:schemas-microsoft-com:office:word'
xmlns='http://www.w3.org/TR/REC-html40'>
<head>
<meta charset='utf-8'>
<title>${RESTAURANT_NAME}</title>
<!--[if gte mso 9]>
<xml><w:WordDocument><w:View>Print</w:View></w:WordDocument></xml>
<![endif]-->
<style>
  body { font-family: Arial, sans-serif; text-align: center; margin: 0; padding: 40pt; }
  h1 { font-size: 22pt; color: #1a1a1a; margin-bottom: 10pt; }
  .url { font-size: 10pt; color: #888888; font-family: Courier New, monospace; margin-top: 6pt; word-break: break-all; }
  .custom { font-size: 12pt; color: #555555; margin-top: 8pt; }
</style>
</head>
<body>
<h1>${RESTAURANT_NAME}</h1>
<img src="${imgData}" width="280" height="280" style="display:block;margin:0 auto;">
${customText ? `<p class="custom">${customText}</p>` : ''}
<p class="url">${PUBLIC_URL_FULL}</p>
</body>
</html>`;

    const blob = new Blob(['﻿', html], { type: 'application/msword' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = `qrcode-${RESTAURANT_NAME.toLowerCase().replace(/\s+/g, '-')}.doc`;
    a.click();
    setTimeout(() => URL.revokeObjectURL(url), 1000);
}
</script>
@endpush
