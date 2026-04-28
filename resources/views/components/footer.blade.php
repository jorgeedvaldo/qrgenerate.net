{{-- Site Footer --}}
<hr>
<footer class="text-center text-muted" style="margin-bottom: 20px;">
    <p style="margin-bottom:8px;">
        @if(($locale ?? 'en') === 'pt')
            <a href="{{ url('/pt') }}">Gerador de QR Code</a> &middot;
            <a href="{{ url('/pt/qr-code-para-whatsapp') }}">QR Code para WhatsApp</a> &middot;
            <a href="{{ url('/pt/qr-code-para-wifi') }}">QR Code para Wi-Fi</a> &middot;
            <a href="{{ url('/pt/qr-code-com-logotipo') }}">QR Code com Logotipo</a> &middot;
            <a href="{{ url('/pt/artigos') }}">Artigos</a> &middot;
            <a href="{{ url('/') }}">English</a>
            <br>
            <a href="{{ url('/pt/sobre') }}" style="font-size: 13px;">Sobre</a> &middot;
            <a href="{{ url('/pt/contacto') }}" style="font-size: 13px;">Contacto</a> &middot;
            <a href="{{ url('/pt/politica-de-privacidade') }}" style="font-size: 13px;">Política de Privacidade</a> &middot;
            <a href="{{ url('/pt/termos-de-uso') }}" style="font-size: 13px;">Termos de Uso</a>
        @else
            <a href="{{ url('/free-qr-code-generator') }}">Free QR Code Generator</a> &middot;
            <a href="{{ url('/qr-code-for-whatsapp') }}">QR Code for WhatsApp</a> &middot;
            <a href="{{ url('/qr-code-for-wifi') }}">QR Code for Wi-Fi</a> &middot;
            <a href="{{ url('/qr-code-with-logo') }}">QR Code with Logo</a> &middot;
            <a href="{{ url('/articles') }}">Articles</a> &middot;
            <a href="{{ url('/pt') }}">Português</a>
            <br>
            <a href="{{ url('/about') }}" style="font-size: 13px;">About Us</a> &middot;
            <a href="{{ url('/contact') }}" style="font-size: 13px;">Contact</a> &middot;
            <a href="{{ url('/privacy-policy') }}" style="font-size: 13px;">Privacy Policy</a> &middot;
            <a href="{{ url('/terms-of-use') }}" style="font-size: 13px;">Terms of Use</a>
        @endif
    </p>
    <p>&copy; {{ date('Y') }} {{ config('qrgenerate.name') }}.
        @if(($locale ?? 'en') === 'pt')
            Todos os direitos reservados.
        @else
            All rights reserved.
        @endif
    </p>
</footer>
