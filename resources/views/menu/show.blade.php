<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $menu->restaurant_name }} – Cardápio Digital</title>
    <meta name="description" content="{{ $menu->description ?: 'Cardápio digital de ' . $menu->restaurant_name }}">
    <meta property="og:title" content="{{ $menu->restaurant_name }} – Cardápio">
    <meta property="og:description" content="{{ $menu->description ?: 'Veja nosso cardápio digital' }}">
    @if($menu->cover_url)
    <meta property="og:image" content="{{ $menu->cover_url }}">
    @endif
    <meta name="theme-color" content="{{ $menu->primary_color }}">
    <link rel="canonical" href="{{ $menu->publicUrl() }}">
    <link rel="alternate" hreflang="pt" href="{{ $menu->publicUrl() }}">
    <link rel="alternate" hreflang="x-default" href="{{ $menu->publicUrl() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: {{ $menu->primary_color }};
            --accent: {{ $menu->accent_color }};
            --primary-light: {{ $menu->primary_color }}22;
            --text: #1a1a1a;
            --muted: #6b7280;
            --border: #e5e7eb;
            --surface: #f9fafb;
            --white: #ffffff;
            --radius: 14px;
            --shadow: 0 2px 12px rgba(0,0,0,.08);
            --shadow-lg: 0 8px 32px rgba(0,0,0,.12);
        }
        html { scroll-behavior: smooth; }
        body { font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif; background: var(--surface); color: var(--text); min-height: 100vh; }

        /* Hero */
        .hero {
            position: relative;
            min-height: 220px;
            background: linear-gradient(160deg, var(--primary) 0%, var(--accent) 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            padding: 24px 20px 0;
            overflow: hidden;
        }
        .hero-cover {
            position: absolute;
            inset: 0;
            object-fit: cover;
            width: 100%;
            height: 100%;
            opacity: .35;
        }
        .hero-content {
            position: relative;
            z-index: 1;
            text-align: center;
            width: 100%;
            max-width: 680px;
        }
        .hero-logo {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid rgba(255,255,255,.6);
            box-shadow: 0 4px 16px rgba(0,0,0,.25);
            margin-bottom: 12px;
        }
        .hero-logo-placeholder {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255,255,255,.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            margin: 0 auto 12px;
            border: 3px solid rgba(255,255,255,.4);
        }
        .hero h1 {
            color: #fff;
            font-size: 26px;
            font-weight: 800;
            text-shadow: 0 2px 8px rgba(0,0,0,.25);
            margin-bottom: 6px;
            line-height: 1.2;
        }
        .hero p {
            color: rgba(255,255,255,.85);
            font-size: 14px;
            margin-bottom: 14px;
            max-width: 420px;
            margin-left: auto;
            margin-right: auto;
        }
        .hero-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            justify-content: center;
            padding-bottom: 20px;
        }
        .hero-chip {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: rgba(255,255,255,.18);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255,255,255,.3);
            color: #fff;
            border-radius: 99px;
            padding: 5px 12px;
            font-size: 12px;
            font-weight: 500;
            text-decoration: none;
            transition: background .15s;
        }
        .hero-chip:hover { background: rgba(255,255,255,.28); color: #fff; text-decoration: none; }

        /* Sticky Nav */
        .section-nav-wrap {
            position: sticky;
            top: 0;
            z-index: 100;
            background: var(--white);
            border-bottom: 1px solid var(--border);
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
        }
        .section-nav {
            display: flex;
            gap: 0;
            overflow-x: auto;
            max-width: 900px;
            margin: 0 auto;
            padding: 0 12px;
            scrollbar-width: none;
        }
        .section-nav::-webkit-scrollbar { display: none; }
        .nav-item {
            flex-shrink: 0;
            padding: 14px 16px;
            font-size: 13px;
            font-weight: 600;
            color: var(--muted);
            cursor: pointer;
            border-bottom: 3px solid transparent;
            transition: all .2s;
            white-space: nowrap;
        }
        .nav-item:hover { color: var(--primary); }
        .nav-item.active { color: var(--primary); border-bottom-color: var(--primary); }

        /* Content */
        .content { max-width: 900px; margin: 0 auto; padding: 28px 16px 80px; }

        /* Section */
        .menu-section { margin-bottom: 36px; }
        .section-title {
            font-size: 20px;
            font-weight: 800;
            color: var(--text);
            margin-bottom: 4px;
            padding-bottom: 10px;
            border-bottom: 2px solid var(--primary-light);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .section-title::before {
            content: '';
            display: inline-block;
            width: 4px;
            height: 22px;
            background: var(--primary);
            border-radius: 2px;
        }
        .section-desc { color: var(--muted); font-size: 13px; margin-bottom: 14px; }

        /* Item Grid */
        .items-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 14px;
        }
        @media(max-width: 480px) {
            .items-grid { grid-template-columns: 1fr; }
        }

        /* Item Card */
        .item-card {
            background: var(--white);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: transform .2s, box-shadow .2s;
            position: relative;
        }
        .item-card:hover { transform: translateY(-2px); box-shadow: var(--shadow-lg); }
        .item-card.unavailable { opacity: .55; }
        .item-card.featured { border: 2px solid var(--primary); }
        .featured-ribbon {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--primary);
            color: #fff;
            font-size: 10px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 99px;
            text-transform: uppercase;
            letter-spacing: .5px;
        }
        .item-image {
            width: 100%;
            height: 160px;
            object-fit: cover;
            display: block;
        }
        .item-body { padding: 14px; flex: 1; display: flex; flex-direction: column; }
        .item-name {
            font-size: 15px;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 4px;
            line-height: 1.3;
        }
        .item-description {
            font-size: 12px;
            color: var(--muted);
            line-height: 1.5;
            flex: 1;
            margin-bottom: 10px;
        }
        .item-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 6px;
            margin-top: auto;
        }
        .item-price {
            font-size: 17px;
            font-weight: 800;
            color: var(--primary);
        }
        .item-badges { display: flex; flex-wrap: wrap; gap: 4px; }
        .badge {
            font-size: 10px;
            font-weight: 600;
            padding: 2px 7px;
            border-radius: 99px;
            white-space: nowrap;
        }
        .badge-vegan      { background: #dcfce7; color: #15803d; }
        .badge-vegetariano { background: #d9f99d; color: #3f6212; }
        .badge-sem_gluten { background: #fef9c3; color: #854d0e; }
        .badge-picante    { background: #fee2e2; color: #991b1b; }
        .unavail-tag {
            font-size: 10px;
            font-weight: 700;
            color: #9ca3af;
            background: #f3f4f6;
            border-radius: 99px;
            padding: 2px 8px;
        }

        /* Footer */
        .menu-footer {
            text-align: center;
            padding: 20px;
            border-top: 1px solid var(--border);
            margin-top: 20px;
            color: var(--muted);
            font-size: 12px;
        }
        .menu-footer a { color: var(--primary); text-decoration: none; font-weight: 600; }
        .menu-footer a:hover { text-decoration: underline; }

        /* WhatsApp FAB */
        .fab-whatsapp {
            position: fixed;
            bottom: 24px;
            right: 20px;
            width: 56px;
            height: 56px;
            background: #25d366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 16px rgba(37,211,102,.4);
            text-decoration: none;
            z-index: 200;
            transition: transform .2s, box-shadow .2s;
        }
        .fab-whatsapp:hover { transform: scale(1.08); box-shadow: 0 6px 24px rgba(37,211,102,.5); }
        .fab-whatsapp svg { width: 28px; height: 28px; fill: #fff; }

        /* Badge map labels */
        .badge-label-vegan::before { content: '🌿 '; }
        .badge-label-vegetariano::before { content: '🥗 '; }
        .badge-label-sem_gluten::before { content: '🌾 '; }
        .badge-label-picante::before { content: '🌶️ '; }
    </style>
</head>
<body>

{{-- Hero --}}
<div class="hero">
    @if($menu->cover_url)
    <img src="{{ $menu->cover_url }}" alt="" class="hero-cover" loading="lazy">
    @endif
    <div class="hero-content">
        @if($menu->logo_url)
        <img src="{{ $menu->logo_url }}" alt="{{ $menu->restaurant_name }}" class="hero-logo">
        @else
        <div class="hero-logo-placeholder">🍽️</div>
        @endif
        <h1>{{ $menu->restaurant_name }}</h1>
        @if($menu->description)
        <p>{{ $menu->description }}</p>
        @endif
        <div class="hero-meta">
            @if($menu->address)
            <span class="hero-chip">📍 {{ $menu->address }}</span>
            @endif
            @if($menu->phone)
            <a href="tel:{{ preg_replace('/\D/', '', $menu->phone) }}" class="hero-chip">📞 {{ $menu->phone }}</a>
            @endif
            @if($menu->instagram)
            <a href="https://instagram.com/{{ ltrim($menu->instagram, '@') }}" target="_blank" class="hero-chip">📸 {{ $menu->instagram }}</a>
            @endif
            @if($menu->website)
            <a href="{{ $menu->website }}" target="_blank" class="hero-chip">🌐 Site</a>
            @endif
        </div>
    </div>
</div>

{{-- Section Navigation --}}
@if($menu->sections->count() > 1)
<div class="section-nav-wrap">
    <div class="section-nav" id="sectionNav">
        @foreach($menu->sections as $section)
        <div class="nav-item" data-target="section-{{ $section->id }}" onclick="scrollToSection('section-{{ $section->id }}', this)">
            {{ $section->name }}
        </div>
        @endforeach
    </div>
</div>
@endif

{{-- Menu Content --}}
<div class="content">

    @if(session('success'))
    <div style="background:#dcfce7; border:1px solid #86efac; color:#15803d; border-radius:10px; padding:12px 16px; margin-bottom:20px; font-size:14px; font-weight:600;">
        ✅ {{ session('success') }}
    </div>
    @endif

    @foreach($menu->sections as $section)
    <div class="menu-section" id="section-{{ $section->id }}">
        <h2 class="section-title">{{ $section->name }}</h2>
        @if($section->description)
        <p class="section-desc">{{ $section->description }}</p>
        @endif

        @if($section->items->count() > 0)
        <div class="items-grid">
            @foreach($section->items as $item)
            <div class="item-card {{ $item->is_featured ? 'featured' : '' }} {{ !$item->is_available ? 'unavailable' : '' }}">
                @if($item->is_featured)
                <div class="featured-ribbon">⭐ Destaque</div>
                @endif

                @if($item->image_url)
                <img src="{{ $item->image_url }}" alt="{{ $item->name }}" class="item-image" loading="lazy">
                @endif

                <div class="item-body">
                    <div class="item-name">{{ $item->name }}</div>
                    @if($item->description)
                    <div class="item-description">{{ $item->description }}</div>
                    @endif
                    <div class="item-footer">
                        @if($item->price !== null)
                        <div class="item-price">{{ $item->formattedPrice() }}</div>
                        @else
                        <div></div>
                        @endif
                        <div style="display:flex; flex-direction:column; align-items:flex-end; gap:4px;">
                            @if(!$item->is_available)
                            <span class="unavail-tag">Indisponível</span>
                            @endif
                            @if($item->badges && count($item->badges) > 0)
                            <div class="item-badges">
                                @foreach($item->badges as $badge)
                                <span class="badge badge-{{ $badge }} badge-label-{{ $badge }}">
                                    @php
                                    $badgeLabels = [
                                        'vegan' => 'Vegano',
                                        'vegetariano' => 'Vegetariano',
                                        'sem_gluten' => 'Sem Glúten',
                                        'picante' => 'Picante',
                                    ];
                                    @endphp
                                    {{ $badgeLabels[$badge] ?? $badge }}
                                </span>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
    @endforeach
</div>

{{-- Footer --}}
<div class="menu-footer">
    <p>
        Cardápio digital criado com <a href="{{ route('menu.landing.pt') }}" target="_blank">QRGenerate.net</a> · Gratuito e sem cadastro
        &nbsp;·&nbsp;
        <a href="{{ route('menu.landing.en') }}" target="_blank" style="color:#9ca3af; font-size:11px;">Digital menu for restaurants</a>
    </p>
</div>

{{-- WhatsApp FAB --}}
@if($menu->whatsapp)
<a href="https://wa.me/{{ preg_replace('/\D/', '', $menu->whatsapp) }}" target="_blank" class="fab-whatsapp" title="Falar pelo WhatsApp">
    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
    </svg>
</a>
@endif

<script>
function scrollToSection(id, navItem) {
    const el = document.getElementById(id);
    if (!el) return;
    const offset = document.querySelector('.section-nav-wrap')?.offsetHeight || 0;
    const top = el.getBoundingClientRect().top + window.scrollY - offset - 12;
    window.scrollTo({ top, behavior: 'smooth' });
    document.querySelectorAll('.nav-item').forEach(n => n.classList.remove('active'));
    navItem.classList.add('active');
}

// Highlight nav on scroll
const sections = document.querySelectorAll('.menu-section');
const navItems = document.querySelectorAll('.nav-item');
if (navItems.length > 0) {
    navItems[0].classList.add('active');
    window.addEventListener('scroll', () => {
        const navH = document.querySelector('.section-nav-wrap')?.offsetHeight || 0;
        let current = null;
        sections.forEach(sec => {
            const rect = sec.getBoundingClientRect();
            if (rect.top <= navH + 40) current = sec.id;
        });
        if (current) {
            navItems.forEach(n => {
                n.classList.toggle('active', n.dataset.target === current);
            });
        }
    }, { passive: true });
}
</script>
</body>
</html>
