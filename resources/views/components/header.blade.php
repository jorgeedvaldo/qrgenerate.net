{{-- Site Header / Navbar with Language Switcher --}}
@php $navLocale = $locale ?? 'en'; $navIsPt = $navLocale === 'pt'; @endphp
<nav class="navbar navbar-custom">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{ $navIsPt ? url('/pt') : url('/') }}">
                <span class="glyphicon glyphicon-qrcode"></span> {{ config('qrgenerate.name') }}
            </a>
        </div>
        <div class="navbar-nav-wrap">
            <ul class="nav navbar-nav navbar-right" style="margin-top:8px;">
                <li>
                    <a href="{{ $navIsPt ? route('invitation.landing.pt') : route('invitation.landing.en') }}"
                       style="color:#fff;padding:6px 14px;font-size:13px;font-weight:600;background:rgba(255,255,255,.15);border-radius:6px;margin-right:6px;display:inline-block;"
                       title="{{ $navIsPt ? 'Convite de Casamento Online' : 'Wedding Invitation Generator' }}">
                        💍 {{ $navIsPt ? 'Convites' : 'Invitations' }}
                    </a>
                </li>
                <li>
                    <a href="{{ $navIsPt ? route('menu.landing.pt') : route('menu.landing.en') }}"
                       style="color:#fff;padding:6px 14px;font-size:13px;font-weight:600;background:rgba(255,255,255,.15);border-radius:6px;margin-right:6px;display:inline-block;"
                       title="{{ $navIsPt ? 'Gerador de Cardápio Digital' : 'Digital Menu Generator' }}">
                        🍽️ {{ $navIsPt ? 'Cardápio Digital' : 'Digital Menu' }}
                    </a>
                </li>

                @auth
                    <li>
                        <a href="{{ route('invitations.index') }}" style="color:#fff;padding:6px 12px;font-size:13px;font-weight:600;">
                            <span class="glyphicon glyphicon-user"></span> {{ $navIsPt ? 'Meus convites' : 'My invitations' }}
                        </a>
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" style="background:none;border:none;color:#fff;padding:6px 12px;font-size:13px;cursor:pointer;">
                                {{ $navIsPt ? 'Sair' : 'Sign out' }}
                            </button>
                        </form>
                    </li>
                @else
                    <li>
                        <a href="{{ $navIsPt ? route('login.pt') : route('login') }}"
                           style="color:#fff;padding:6px 12px;font-size:13px;font-weight:600;">
                            {{ $navIsPt ? 'Entrar' : 'Sign in' }}
                        </a>
                    </li>
                @endauth

                <li>
                    @if($navIsPt)
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
    </div>
</nav>
