{{-- Site Header / Navbar with Language Switcher --}}
<nav class="navbar navbar-custom">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ ($locale ?? 'en') === 'pt' ? url('/pt') : url('/') }}">
                <span class="glyphicon glyphicon-qrcode"></span> {{ config('qrgenerate.name') }}
            </a>
        </div>
        <ul class="nav navbar-nav navbar-right" style="margin-top:8px;">
            <li>
                @if(($locale ?? 'en') === 'pt')
                    <a href="{{ route('menu.landing.pt') }}"
                       style="color:#fff;padding:6px 14px;font-size:13px;font-weight:600;background:rgba(255,255,255,.15);border-radius:6px;margin-right:6px;display:inline-block;"
                       title="Gerador de Cardápio Digital">
                        🍽️ Cardápio Digital
                    </a>
                @else
                    <a href="{{ route('menu.landing.en') }}"
                       style="color:#fff;padding:6px 14px;font-size:13px;font-weight:600;background:rgba(255,255,255,.15);border-radius:6px;margin-right:6px;display:inline-block;"
                       title="Digital Menu Generator">
                        🍽️ Digital Menu
                    </a>
                @endif
            </li>
            <li>
                @if(($locale ?? 'en') === 'pt')
                    <a href="{{ url('/') }}" style="color:#fff;padding:6px 12px;font-size:13px;" title="Switch to English">
                        🇬🇧 EN
                    </a>
                @else
                    <a href="{{ url('/pt') }}" style="color:#fff;padding:6px 12px;font-size:13px;" title="Mudar para Português">
                        🇵🇹 PT
                    </a>
                @endif
            </li>
        </ul>
    </div>
</nav>
