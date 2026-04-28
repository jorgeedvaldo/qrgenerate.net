{{-- Site Footer --}}
<hr>
<footer class="text-center text-muted" style="margin-bottom: 20px;">
    <p style="margin-bottom:8px;">
        @if(($locale ?? 'en') === 'pt')
            <a href="{{ url('/pt') }}">Início</a> &middot;
            <a href="{{ url('/pt/gerador-de-qr-code-gratis') }}">Gerador Grátis</a> &middot;
            <a href="{{ url('/pt/gerador-de-qr-code-privado') }}">Privacidade</a> &middot;
            <a href="{{ url('/') }}">English</a>
        @else
            <a href="{{ url('/') }}">Home</a> &middot;
            <a href="{{ url('/free-qr-code-generator') }}">Free Generator</a> &middot;
            <a href="{{ url('/private-qr-code-generator') }}">Privacy</a> &middot;
            <a href="{{ url('/pt') }}">Português</a>
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
