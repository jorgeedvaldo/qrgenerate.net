@php
    use Illuminate\Support\Str;

    $fonts = [
        'cormorant'  => ['Cormorant+Garamond:wght@300;400;500;600;700', "'Cormorant Garamond', Georgia, serif"],
        'playfair'   => ['Playfair+Display:wght@400;500;600;700', "'Playfair Display', Georgia, serif"],
        'lora'       => ['Lora:wght@400;500;600;700', "'Lora', Georgia, serif"],
        'montserrat' => ['Montserrat:wght@300;400;500;600;700', "'Montserrat', Helvetica, sans-serif"],
    ];
    [$fontQuery, $fontStack] = $fonts[$invitation->font] ?? $fonts['cormorant'];

    $months = [1=>'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
    $weekdays = [0=>'Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'];

    $starts   = $invitation->startsAt();
    $longDate = $weekdays[(int) $starts->format('w')] . ', ' . $starts->day . ' de ' . $months[(int) $starts->month] . ' de ' . $starts->year;

    $isWedding = $invitation->type === 'wedding';
    $eventWord = $isWedding ? 'casamento' : 'noivado';

    $hasGifts = $invitation->gifts->isNotEmpty() || filled($invitation->pix_key) || filled($invitation->bank_details) || filled($invitation->gift_message);
    $hasGallery = $invitation->photos->isNotEmpty();
    $hasStory = filled($invitation->story);
    $hasDressCode = filled($invitation->dress_code) || filled($invitation->dress_code_notes);
    $showRsvp = $invitation->rsvp_enabled;
    $showGuestbook = $invitation->guestbook_enabled;

    $maxCompanions = $invitation->allow_companions ? $invitation->max_companions : 0;
    $guestCode = $guest?->code;
@endphp
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $invitation->coupleNames() }} — Convite de {{ ucfirst($eventWord) }}</title>
    <meta name="description" content="{{ $invitation->tagline ?: 'Convite de ' . $eventWord . ' de ' . $invitation->coupleNames() . ' — ' . $longDate }}">
    <meta name="robots" content="noindex, nofollow">
    <link rel="canonical" href="{{ $invitation->publicUrl() }}">
    <meta name="theme-color" content="{{ $invitation->primary_color }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $invitation->coupleNames() }} — Convite de {{ ucfirst($eventWord) }}">
    <meta property="og:description" content="{{ $invitation->tagline ?: $longDate }}">
    <meta property="og:url" content="{{ $invitation->publicUrl() }}">
    @if($invitation->cover_url)
        <meta property="og:image" content="{{ Str::startsWith($invitation->cover_url, 'http') ? $invitation->cover_url : url($invitation->cover_url) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family={{ $fontQuery }}&family=Great+Vibes&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --primary: {{ $invitation->primary_color }};
            --accent: {{ $invitation->accent_color }};
            --primary-soft: {{ $invitation->primary_color }}1f;
            --primary-line: {{ $invitation->primary_color }}44;
            --ink: #2d2a26;
            --muted: #7d766d;
            --paper: #fdfbf7;
            --card: #ffffff;
            --line: #ece5db;
            --radius: 16px;
            --serif: {!! $fontStack !!};
            --script: 'Great Vibes', cursive;
        }
        html { scroll-behavior: smooth; scroll-padding-top: 64px; }
        body {
            font-family: var(--serif);
            background: var(--paper);
            color: var(--ink);
            line-height: 1.65;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Templates ───────────────────────────────────────────────── */
        body[data-template="botanical"] {
            background-color: var(--paper);
            background-image:
                radial-gradient(circle at 12% 8%, var(--primary-soft) 0, transparent 22%),
                radial-gradient(circle at 88% 92%, var(--primary-soft) 0, transparent 22%);
            background-attachment: fixed;
        }
        body[data-template="modern"] { --paper: #ffffff; --radius: 4px; background: #fff; }
        body[data-template="modern"] .section-title { letter-spacing: .22em; }
        body[data-template="romantic"] {
            background-image: linear-gradient(180deg, {{ $invitation->primary_color }}12 0%, transparent 320px);
        }

        /* ── Nav ─────────────────────────────────────────────────────── */
        .nav {
            position: sticky; top: 0; z-index: 50;
            background: rgba(253,251,247,.93);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
        }
        .nav-inner {
            max-width: 900px; margin: 0 auto; padding: 0 14px;
            display: flex; gap: 4px; overflow-x: auto; justify-content: center;
            scrollbar-width: none;
        }
        .nav-inner::-webkit-scrollbar { display: none; }
        .nav a {
            flex: 0 0 auto; padding: 14px 12px; font-size: 12.5px; letter-spacing: .12em;
            text-transform: uppercase; color: var(--muted); text-decoration: none; white-space: nowrap;
            border-bottom: 2px solid transparent; transition: color .2s, border-color .2s;
        }
        .nav a:hover { color: var(--primary); border-bottom-color: var(--primary); }

        /* ── Hero ────────────────────────────────────────────────────── */
        .hero {
            position: relative; min-height: 86vh; display: flex; flex-direction: column;
            align-items: center; justify-content: center; text-align: center;
            padding: 56px 20px; overflow: hidden;
            background: linear-gradient(150deg, var(--primary) 0%, var(--accent) 100%);
            color: #fff;
        }
        .hero-bg {
            position: absolute; inset: 0; width: 100%; height: 100%;
            object-fit: cover; opacity: .45;
        }
        .hero-veil { position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,.28) 0%, rgba(0,0,0,.42) 100%); }
        .hero-inner { position: relative; z-index: 1; max-width: 680px; width: 100%; }
        .hero-kicker {
            font-size: 12px; letter-spacing: .3em; text-transform: uppercase;
            opacity: .9; margin-bottom: 18px;
        }
        .hero-names {
            font-family: var(--script); font-size: clamp(46px, 13vw, 92px);
            line-height: 1.08; margin: 0 0 6px; text-shadow: 0 2px 18px rgba(0,0,0,.3);
        }
        .hero-amp { display: block; font-size: .5em; opacity: .85; margin: 2px 0; }
        .hero-tagline { font-size: clamp(15px, 2.6vw, 19px); font-style: italic; opacity: .95; margin-top: 10px; }
        .hero-rule { width: 70px; height: 1px; background: rgba(255,255,255,.65); margin: 24px auto; }
        .hero-date { font-size: clamp(14px, 3vw, 17px); letter-spacing: .16em; text-transform: uppercase; }
        .hero-time { font-size: 14px; opacity: .9; margin-top: 4px; }
        .hero-scroll {
            position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);
            z-index: 1; color: #fff; font-size: 22px; opacity: .8; text-decoration: none;
            animation: bob 2.2s ease-in-out infinite;
        }
        @keyframes bob { 0%,100% { transform: translate(-50%, 0); } 50% { transform: translate(-50%, 7px); } }

        /* ── Personalised greeting ───────────────────────────────────── */
        .greeting {
            background: var(--card); border: 1px solid var(--primary-line);
            border-radius: var(--radius); padding: 22px 24px; text-align: center;
            max-width: 620px; margin: -42px auto 0; position: relative; z-index: 5;
            box-shadow: 0 12px 34px rgba(0,0,0,.09);
        }
        .greeting-label { font-size: 11px; letter-spacing: .24em; text-transform: uppercase; color: var(--muted); }
        .greeting-name { font-family: var(--script); font-size: clamp(28px, 7vw, 38px); color: var(--primary); line-height: 1.25; margin-top: 2px; }
        .greeting-note { font-size: 14.5px; color: var(--muted); margin-top: 8px; }

        /* ── Sections ────────────────────────────────────────────────── */
        .section { max-width: 820px; margin: 0 auto; padding: 60px 20px; }
        .section + .section { padding-top: 10px; }
        .section-head { text-align: center; margin-bottom: 34px; }
        .section-title {
            font-size: 12px; letter-spacing: .3em; text-transform: uppercase;
            color: var(--primary); font-weight: 600;
        }
        .section-heading { font-size: clamp(26px, 6vw, 34px); margin-top: 8px; font-weight: 500; }
        .section-sub { color: var(--muted); font-size: 15px; margin-top: 8px; }
        .ornament { text-align: center; color: var(--primary); font-size: 18px; letter-spacing: .5em; margin: 10px 0 0; opacity: .7; }

        .card {
            background: var(--card); border: 1px solid var(--line);
            border-radius: var(--radius); padding: 24px;
        }
        .card + .card { margin-top: 16px; }

        /* ── Countdown ───────────────────────────────────────────────── */
        .countdown { display: flex; justify-content: center; gap: 10px; flex-wrap: wrap; }
        .cd-box {
            min-width: 78px; padding: 16px 10px; background: var(--card);
            border: 1px solid var(--primary-line); border-radius: var(--radius); text-align: center;
        }
        .cd-num { font-size: 30px; font-weight: 600; color: var(--primary); line-height: 1; font-variant-numeric: tabular-nums; }
        .cd-lbl { font-size: 10.5px; letter-spacing: .16em; text-transform: uppercase; color: var(--muted); margin-top: 6px; }
        .cd-done { text-align: center; font-size: 19px; color: var(--primary); font-style: italic; }

        /* ── Story ───────────────────────────────────────────────────── */
        .story { display: grid; gap: 28px; align-items: center; }
        @media (min-width: 720px) { .story.has-photo { grid-template-columns: 1fr 1fr; } }
        .story-photo { width: 100%; border-radius: var(--radius); object-fit: cover; aspect-ratio: 4 / 5; box-shadow: 0 10px 30px rgba(0,0,0,.1); }
        .story-text { white-space: pre-line; font-size: 16.5px; color: #4a453e; }

        /* ── Events / local ──────────────────────────────────────────── */
        .event-card { position: relative; padding-left: 24px; }
        .event-card::before {
            content: ''; position: absolute; left: 0; top: 24px; bottom: 24px;
            width: 3px; background: var(--primary); border-radius: 3px;
        }
        .event-kind { font-size: 11px; letter-spacing: .2em; text-transform: uppercase; color: var(--primary); font-weight: 600; }
        .event-title { font-size: 23px; margin: 4px 0 10px; }
        .event-row { display: flex; gap: 10px; font-size: 15px; color: #4a453e; margin-bottom: 6px; }
        .event-row .ico { color: var(--primary); flex: 0 0 18px; }
        .event-actions { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 16px; }

        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 11px 20px; border-radius: 999px; font-size: 14px; font-weight: 600;
            text-decoration: none; cursor: pointer; border: 1.5px solid var(--primary);
            background: var(--primary); color: #fff; font-family: inherit;
            transition: filter .18s, transform .18s;
        }
        .btn:hover { filter: brightness(1.08); transform: translateY(-1px); }
        .btn-ghost { background: transparent; color: var(--primary); }
        .btn-ghost:hover { background: var(--primary-soft); }
        .btn-wide { width: 100%; }

        /* ── Gallery ─────────────────────────────────────────────────── */
        .gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; }
        .gallery figure { margin: 0; position: relative; }
        .gallery img {
            width: 100%; aspect-ratio: 1; object-fit: cover; border-radius: 10px;
            cursor: zoom-in; transition: transform .25s, box-shadow .25s; display: block;
        }
        .gallery img:hover { transform: scale(1.02); box-shadow: 0 8px 22px rgba(0,0,0,.14); }
        .gallery figcaption { font-size: 12px; color: var(--muted); margin-top: 5px; text-align: center; }

        .lightbox {
            position: fixed; inset: 0; z-index: 100; background: rgba(0,0,0,.92);
            display: none; align-items: center; justify-content: center; padding: 20px;
        }
        .lightbox.open { display: flex; }
        .lightbox img { max-width: 100%; max-height: 90vh; border-radius: 8px; }
        .lightbox-close {
            position: absolute; top: 14px; right: 18px; background: none; border: none;
            color: #fff; font-size: 34px; cursor: pointer; line-height: 1;
        }

        /* ── Gifts ───────────────────────────────────────────────────── */
        .pix-box { background: var(--primary-soft); border: 1px dashed var(--primary-line); border-radius: 12px; padding: 18px; text-align: center; }
        .pix-key {
            font-family: ui-monospace, Menlo, Consolas, monospace; font-size: 14px;
            word-break: break-all; background: #fff; border: 1px solid var(--line);
            border-radius: 8px; padding: 10px 12px; margin: 10px 0;
        }
        .gift-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 14px; }
        .gift {
            background: var(--card); border: 1px solid var(--line); border-radius: 12px;
            padding: 14px; display: flex; flex-direction: column; gap: 8px;
        }
        .gift img { width: 100%; aspect-ratio: 4/3; object-fit: cover; border-radius: 8px; }
        .gift-name { font-weight: 600; font-size: 16px; }
        .gift-desc { font-size: 13.5px; color: var(--muted); }
        .gift-price { font-size: 15px; color: var(--primary); font-weight: 600; }
        .gift-taken { font-size: 12.5px; color: var(--muted); font-style: italic; margin-top: auto; }
        .gift form { margin-top: auto; display: flex; gap: 6px; }
        .gift form input { flex: 1; min-width: 0; }

        /* ── Forms ───────────────────────────────────────────────────── */
        label.fl { display: block; font-size: 12.5px; letter-spacing: .08em; text-transform: uppercase; color: var(--muted); margin-bottom: 5px; }
        input[type=text], input[type=email], input[type=tel], input[type=number], select, textarea {
            width: 100%; padding: 11px 13px; border: 1.5px solid var(--line); border-radius: 9px;
            font-size: 15px; font-family: inherit; background: #fff; color: var(--ink);
        }
        input:focus, select:focus, textarea:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-soft); }
        .field { margin-bottom: 15px; }
        .field-row { display: grid; gap: 15px; }
        @media (min-width: 620px) { .field-row.two { grid-template-columns: 1fr 1fr; } }
        .choice-row { display: flex; gap: 10px; flex-wrap: wrap; }
        .choice {
            flex: 1 1 140px; display: flex; align-items: center; justify-content: center; gap: 8px;
            padding: 14px; border: 1.5px solid var(--line); border-radius: 12px; cursor: pointer;
            font-size: 15px; font-weight: 600; background: #fff; transition: all .18s; text-align: center;
        }
        .choice input { position: absolute; opacity: 0; width: 0; height: 0; }
        .choice.selected { border-color: var(--primary); background: var(--primary-soft); color: var(--primary); }
        .alert { border-radius: 10px; padding: 13px 15px; font-size: 14.5px; margin-bottom: 18px; }
        .alert-ok { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        .alert-info { background: var(--primary-soft); border: 1px solid var(--primary-line); color: var(--accent); }
        .alert-bad { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

        /* ── Guestbook ───────────────────────────────────────────────── */
        .note { background: var(--card); border: 1px solid var(--line); border-left: 3px solid var(--primary); border-radius: 10px; padding: 14px 16px; }
        .note + .note { margin-top: 10px; }
        .note-name { font-weight: 600; font-size: 15px; }
        .note-when { font-size: 12px; color: var(--muted); }
        .note-text { font-size: 15px; margin-top: 6px; white-space: pre-line; }

        /* ── Footer ──────────────────────────────────────────────────── */
        .footer { text-align: center; padding: 50px 20px 36px; border-top: 1px solid var(--line); margin-top: 50px; }
        .footer-names { font-family: var(--script); font-size: 34px; color: var(--primary); }
        .footer-hash { font-size: 14px; color: var(--muted); margin-top: 6px; letter-spacing: .06em; }
        .share { display: flex; gap: 10px; justify-content: center; margin-top: 20px; flex-wrap: wrap; }
        .share a, .share button {
            width: 42px; height: 42px; border-radius: 50%; display: inline-flex;
            align-items: center; justify-content: center; background: var(--primary-soft);
            color: var(--primary); border: 1px solid var(--primary-line); text-decoration: none;
            font-size: 17px; cursor: pointer; font-family: inherit;
        }
        .share a:hover, .share button:hover { background: var(--primary); color: #fff; }
        .credit { font-size: 12px; color: #b3aba0; margin-top: 26px; }
        .credit a { color: var(--primary); text-decoration: none; }

        /* ── Music toggle ────────────────────────────────────────────── */
        .music {
            position: fixed; bottom: 18px; right: 18px; z-index: 60;
            width: 48px; height: 48px; border-radius: 50%; border: none;
            background: var(--primary); color: #fff; font-size: 19px; cursor: pointer;
            box-shadow: 0 6px 18px rgba(0,0,0,.22);
        }

        @media (max-width: 480px) {
            .section { padding: 44px 16px; }
            .card { padding: 18px; }
        }
        @media print {
            .nav, .music, .share, .hero-scroll, form { display: none !important; }
            body { background: #fff; }
        }
    </style>
</head>
<body data-template="{{ $invitation->template }}">

<nav class="nav">
    <div class="nav-inner">
        <a href="#inicio">Início</a>
        @if($hasStory)<a href="#historia">Nossa história</a>@endif
        @if($invitation->events->isNotEmpty())<a href="#local">Local</a>@endif
        @if($hasDressCode)<a href="#traje">Traje</a>@endif
        @if($hasGallery)<a href="#galeria">Galeria</a>@endif
        @if($hasGifts)<a href="#presentes">Presentes</a>@endif
        @if($showRsvp)<a href="#rsvp">Confirmar</a>@endif
        @if($showGuestbook)<a href="#recados">Recados</a>@endif
    </div>
</nav>

{{-- ── Hero ───────────────────────────────────────────────────────── --}}
<header class="hero" id="inicio">
    @if($invitation->cover_url)
        <img class="hero-bg" src="{{ $invitation->cover_url }}" alt="" aria-hidden="true">
        <div class="hero-veil"></div>
    @endif
    <div class="hero-inner">
        <p class="hero-kicker">{{ $isWedding ? 'Vamos nos casar' : 'Vamos ficar noivos' }}</p>
        <h1 class="hero-names">
            {{ $invitation->partner_one_name }}
            @if($invitation->partner_two_name)
                <span class="hero-amp">&amp;</span>{{ $invitation->partner_two_name }}
            @endif
        </h1>
        @if($invitation->tagline)
            <p class="hero-tagline">{{ $invitation->tagline }}</p>
        @endif
        <div class="hero-rule"></div>
        <p class="hero-date">{{ $longDate }}</p>
        @if($invitation->event_time)
            <p class="hero-time">às {{ substr($invitation->event_time, 0, 5) }}</p>
        @endif
    </div>
    <a href="#{{ $invitation->countdown_enabled && ! $invitation->isPast() ? 'contagem' : ($hasStory ? 'historia' : 'local') }}"
       class="hero-scroll" aria-label="Ver mais">&#8595;</a>
</header>

{{-- ── Personalised greeting (?c=) ───────────────────────────────── --}}
@if($guestName)
    <div class="greeting">
        <p class="greeting-label">Convite especial para</p>
        <p class="greeting-name">{{ $guestName }}</p>
        <p class="greeting-note">
            {{ $invitation->welcome_message ?: 'É com muita alegria que convidamos você para celebrar este dia conosco.' }}
        </p>
    </div>
@elseif($invitation->welcome_message)
    <div class="greeting">
        <p class="greeting-note" style="margin-top:0;">{{ $invitation->welcome_message }}</p>
    </div>
@endif

{{-- ── Countdown ─────────────────────────────────────────────────── --}}
@if($invitation->countdown_enabled)
<section class="section" id="contagem">
    <div class="section-head">
        <p class="section-title">Contagem regressiva</p>
        <h2 class="section-heading">{{ $invitation->isPast() ? 'Obrigado por celebrar com a gente' : 'Faltam' }}</h2>
    </div>
    <div class="countdown" id="cd" data-target="{{ $starts->format('Y-m-d\TH:i:s') }}">
        <div class="cd-box"><div class="cd-num" id="cd-d">--</div><div class="cd-lbl">Dias</div></div>
        <div class="cd-box"><div class="cd-num" id="cd-h">--</div><div class="cd-lbl">Horas</div></div>
        <div class="cd-box"><div class="cd-num" id="cd-m">--</div><div class="cd-lbl">Minutos</div></div>
        <div class="cd-box"><div class="cd-num" id="cd-s">--</div><div class="cd-lbl">Segundos</div></div>
    </div>
    <p class="cd-done" id="cd-done" style="display:none;">O grande dia chegou! &#128141;</p>
</section>
@endif

{{-- ── Story ─────────────────────────────────────────────────────── --}}
@if($hasStory)
<section class="section" id="historia">
    <div class="section-head">
        <p class="section-title">Nossa história</p>
        <h2 class="section-heading">Como tudo começou</h2>
        <p class="ornament">&#10047;</p>
    </div>
    <div class="story {{ $invitation->couple_photo_url ? 'has-photo' : '' }}">
        @if($invitation->couple_photo_url)
            <img class="story-photo" src="{{ $invitation->couple_photo_url }}" alt="{{ $invitation->coupleNames() }}" loading="lazy">
        @endif
        <div class="story-text">{{ $invitation->story }}</div>
    </div>
</section>
@endif

{{-- ── Events / where it happens ─────────────────────────────────── --}}
@if($invitation->events->isNotEmpty())
<section class="section" id="local">
    <div class="section-head">
        <p class="section-title">Onde e quando</p>
        <h2 class="section-heading">{{ $invitation->events->count() > 1 ? 'A celebração' : 'O local' }}</h2>
        <p class="ornament">&#10047;</p>
    </div>

    @foreach($invitation->events as $event)
        @php
            $kinds = ['ceremony' => 'Cerimónia', 'reception' => 'Recepção', 'party' => 'Festa', 'other' => 'Programa'];
            $eDate = $event->event_date ?: $invitation->event_date;
            $eTime = $event->event_time ?: $invitation->event_time;
            $calStart = \Illuminate\Support\Carbon::parse($eDate->format('Y-m-d') . ' ' . ($eTime ? substr($eTime, 0, 5) : '12:00'));
            $calUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
                . '&text=' . urlencode($event->title . ' — ' . $invitation->coupleNames())
                . '&dates=' . $calStart->format('Ymd\THis') . '/' . $calStart->copy()->addHours(4)->format('Ymd\THis')
                . '&location=' . urlencode(trim(($event->venue_name ? $event->venue_name . ', ' : '') . $event->address))
                . '&details=' . urlencode($invitation->publicUrl($guestCode));
        @endphp
        <div class="card event-card">
            <p class="event-kind">{{ $kinds[$event->kind] ?? 'Programa' }}</p>
            <h3 class="event-title">{{ $event->title }}</h3>

            @if($event->venue_name)
                <p class="event-row"><span class="ico">&#127970;</span><span>{{ $event->venue_name }}</span></p>
            @endif
            @if($event->address)
                <p class="event-row"><span class="ico">&#128205;</span><span>{{ $event->address }}</span></p>
            @endif
            <p class="event-row">
                <span class="ico">&#128197;</span>
                <span>
                    {{ $weekdays[(int) $eDate->format('w')] }}, {{ $eDate->day }} de {{ $months[(int) $eDate->month] }} de {{ $eDate->year }}
                    @if($eTime) &middot; {{ substr($eTime, 0, 5) }} @endif
                </span>
            </p>
            @if($event->notes)
                <p class="event-row"><span class="ico">&#9432;</span><span>{{ $event->notes }}</span></p>
            @endif

            <div class="event-actions">
                @if($event->mapsLink())
                    <a class="btn" href="{{ $event->mapsLink() }}" target="_blank" rel="noopener">Ver no mapa</a>
                @endif
                <a class="btn btn-ghost" href="{{ $calUrl }}" target="_blank" rel="noopener">Adicionar à agenda</a>
            </div>
        </div>
    @endforeach
</section>
@endif

{{-- ── Dress code ────────────────────────────────────────────────── --}}
@if($hasDressCode)
<section class="section" id="traje">
    <div class="section-head">
        <p class="section-title">Traje</p>
        <h2 class="section-heading">{{ $invitation->dress_code ?: 'Como se vestir' }}</h2>
    </div>
    @if($invitation->dress_code_notes)
        <div class="card" style="text-align:center;">
            <p style="font-size:16.5px;color:#4a453e;white-space:pre-line;">{{ $invitation->dress_code_notes }}</p>
        </div>
    @endif
</section>
@endif

{{-- ── Gallery ───────────────────────────────────────────────────── --}}
@if($hasGallery)
<section class="section" id="galeria">
    <div class="section-head">
        <p class="section-title">Galeria</p>
        <h2 class="section-heading">Nossos momentos</h2>
    </div>
    <div class="gallery">
        @foreach($invitation->photos as $photo)
            <figure>
                <img src="{{ $photo->image_url }}" alt="{{ $photo->caption ?: $invitation->coupleNames() }}"
                     loading="lazy" onclick="openLightbox(this.src)">
                @if($photo->caption)<figcaption>{{ $photo->caption }}</figcaption>@endif
            </figure>
        @endforeach
    </div>
</section>

<div class="lightbox" id="lightbox" onclick="closeLightbox()">
    <button class="lightbox-close" type="button" aria-label="Fechar">&times;</button>
    <img id="lightbox-img" src="" alt="">
</div>
@endif

{{-- ── Gifts ─────────────────────────────────────────────────────── --}}
@if($hasGifts)
<section class="section" id="presentes">
    <div class="section-head">
        <p class="section-title">Presentes</p>
        <h2 class="section-heading">Lista de presentes</h2>
        @if($invitation->gift_message)
            <p class="section-sub">{{ $invitation->gift_message }}</p>
        @endif
    </div>

    @if(session('gift_done'))
        <div class="alert alert-ok">Obrigado! Reservámos <strong>{{ session('gift_done') }}</strong> no seu nome.</div>
    @endif
    @error('gift')<div class="alert alert-bad">{{ $message }}</div>@enderror

    @if($invitation->pix_key)
        <div class="card">
            <div class="pix-box">
                <p class="section-title">Pix / Transferência</p>
                <div class="pix-key" id="pixKey">{{ $invitation->pix_key }}</div>
                @if($invitation->pix_name)
                    <p style="font-size:13.5px;color:var(--muted);margin-bottom:12px;">Em nome de {{ $invitation->pix_name }}</p>
                @endif
                <button type="button" class="btn" onclick="copyPix()">Copiar chave</button>
            </div>
        </div>
    @endif

    @if($invitation->bank_details)
        <div class="card">
            <p class="section-title">Dados bancários</p>
            <p style="white-space:pre-line;font-size:15px;margin-top:8px;">{{ $invitation->bank_details }}</p>
        </div>
    @endif

    @if($invitation->gifts->isNotEmpty())
        <div class="gift-grid" style="margin-top:16px;">
            @foreach($invitation->gifts as $gift)
                <div class="gift">
                    @if($gift->image_url)
                        <img src="{{ $gift->image_url }}" alt="{{ $gift->name }}" loading="lazy">
                    @endif
                    <p class="gift-name">{{ $gift->name }}</p>
                    @if($gift->description)<p class="gift-desc">{{ $gift->description }}</p>@endif
                    @if($gift->price !== null)<p class="gift-price">{{ number_format((float) $gift->price, 2, ',', '.') }}</p>@endif
                    @if($gift->store_url)
                        <a class="btn btn-ghost" href="{{ $gift->store_url }}" target="_blank" rel="noopener">Ver na loja</a>
                    @endif

                    @if($gift->is_reserved)
                        <p class="gift-taken">Já reservado{{ $gift->reserved_by ? ' por ' . $gift->reserved_by : '' }}</p>
                    @else
                        <form method="POST" action="{{ route('invitation.gift.reserve', [$invitation->slug, $gift->id]) }}">
                            @csrf
                            <input type="text" name="reserved_by" placeholder="Seu nome" required maxlength="120">
                            <button type="submit" class="btn">Reservar</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>
    @endif
</section>
@endif

{{-- ── RSVP ──────────────────────────────────────────────────────── --}}
@if($showRsvp)
<section class="section" id="rsvp">
    <div class="section-head">
        <p class="section-title">Presença</p>
        <h2 class="section-heading">Confirme a sua presença</h2>
        @if($invitation->rsvp_deadline)
            <p class="section-sub">
                Por favor, responda até
                {{ $invitation->rsvp_deadline->day }} de {{ $months[(int) $invitation->rsvp_deadline->month] }}.
            </p>
        @endif
    </div>

    @if(session('rsvp_done') === 'yes')
        <div class="alert alert-ok">
            Presença confirmada! Obrigado — estamos muito felizes por celebrar com você. &#128141;
        </div>
    @elseif(session('rsvp_done') === 'no')
        <div class="alert alert-info">
            Resposta registada. Vamos sentir a sua falta, mas obrigado por nos avisar.
        </div>
    @endif

    @error('rsvp')<div class="alert alert-bad">{{ $message }}</div>@enderror

    @if($invitation->rsvpOpen())
        <div class="card">
            <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}">
                @csrf
                <input type="hidden" name="guest_code" value="{{ $guestCode }}">
                <input type="hidden" name="guest_name" value="{{ $guestCode ? '' : $guestName }}">

                <div class="field">
                    <label class="fl" for="rsvp-name">Nome completo</label>
                    <input id="rsvp-name" type="text" name="name" required maxlength="120"
                           value="{{ old('name', $guestName) }}" placeholder="Como devemos chamá-lo?">
                </div>

                <div class="field-row two">
                    <div class="field">
                        <label class="fl" for="rsvp-email">E-mail (opcional)</label>
                        <input id="rsvp-email" type="email" name="email" maxlength="200" value="{{ old('email') }}">
                    </div>
                    <div class="field">
                        <label class="fl" for="rsvp-phone">Telefone (opcional)</label>
                        <input id="rsvp-phone" type="tel" name="phone" maxlength="30" value="{{ old('phone') }}">
                    </div>
                </div>

                <div class="field">
                    <label class="fl">Você vai comparecer?</label>
                    <div class="choice-row">
                        <label class="choice selected" id="choice-yes">
                            <input type="radio" name="attending" value="1" checked onchange="toggleAttending(true)">
                            &#10003; Sim, estarei lá
                        </label>
                        <label class="choice" id="choice-no">
                            <input type="radio" name="attending" value="0" onchange="toggleAttending(false)">
                            Não poderei ir
                        </label>
                    </div>
                </div>

                @if($maxCompanions > 0)
                    <div id="companion-fields">
                        <div class="field">
                            <label class="fl" for="rsvp-comp">Acompanhantes (até {{ $maxCompanions }})</label>
                            <select id="rsvp-comp" name="companions" onchange="toggleCompanionNames(this.value)">
                                @for($i = 0; $i <= $maxCompanions; $i++)
                                    <option value="{{ $i }}" @selected((int) old('companions', 0) === $i)>
                                        {{ $i === 0 ? 'Vou sozinho(a)' : $i . ($i === 1 ? ' acompanhante' : ' acompanhantes') }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="field" id="companion-names-field" style="display:none;">
                            <label class="fl" for="rsvp-compnames">Nome dos acompanhantes</label>
                            <input id="rsvp-compnames" type="text" name="companion_names" maxlength="500"
                                   value="{{ old('companion_names') }}" placeholder="Separe por vírgula">
                        </div>
                    </div>
                @endif

                <div class="field">
                    <label class="fl" for="rsvp-msg">Recado para o casal (opcional)</label>
                    <textarea id="rsvp-msg" name="message" rows="3" maxlength="800">{{ old('message') }}</textarea>
                </div>

                <button type="submit" class="btn btn-wide">Enviar resposta</button>
            </form>
        </div>
    @else
        <div class="alert alert-info">As confirmações de presença estão encerradas. Em caso de dúvida, fale diretamente com o casal.</div>
    @endif

    @if($invitation->contact_whatsapp || $invitation->contact_phone || $invitation->contact_email)
        <p style="text-align:center;margin-top:18px;font-size:14.5px;color:var(--muted);">
            Dúvidas?
            @if($invitation->contact_whatsapp)
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $invitation->contact_whatsapp) }}"
                   target="_blank" rel="noopener" style="color:var(--primary);">WhatsApp</a>
            @endif
            @if($invitation->contact_phone)
                &middot; <a href="tel:{{ $invitation->contact_phone }}" style="color:var(--primary);">{{ $invitation->contact_phone }}</a>
            @endif
            @if($invitation->contact_email)
                &middot; <a href="mailto:{{ $invitation->contact_email }}" style="color:var(--primary);">{{ $invitation->contact_email }}</a>
            @endif
        </p>
    @endif
</section>
@endif

{{-- ── Guestbook ─────────────────────────────────────────────────── --}}
@if($showGuestbook)
<section class="section" id="recados">
    <div class="section-head">
        <p class="section-title">Mural</p>
        <h2 class="section-heading">Recados dos convidados</h2>
    </div>

    @if(session('message_done'))
        <div class="alert alert-ok">Obrigado pelo seu recado!</div>
    @endif

    <div class="card">
        <form method="POST" action="{{ route('invitation.message', $invitation->slug) }}">
            @csrf
            <div class="field">
                <label class="fl" for="gb-name">Seu nome</label>
                <input id="gb-name" type="text" name="name" required maxlength="120" value="{{ old('name', $guestName) }}">
            </div>
            <div class="field">
                <label class="fl" for="gb-msg">Mensagem</label>
                <textarea id="gb-msg" name="message" rows="3" required maxlength="600">{{ old('message') }}</textarea>
            </div>
            <button type="submit" class="btn btn-wide">Deixar recado</button>
        </form>
    </div>

    @if($invitation->messages->isNotEmpty())
        <div style="margin-top:18px;">
            @foreach($invitation->messages as $note)
                <div class="note">
                    <p class="note-name">{{ $note->name }} <span class="note-when">&middot; {{ $note->created_at->format('d/m/Y') }}</span></p>
                    <p class="note-text">{{ $note->message }}</p>
                </div>
            @endforeach
        </div>
    @endif
</section>
@endif

{{-- ── Footer ────────────────────────────────────────────────────── --}}
<footer class="footer">
    <p class="footer-names">{{ $invitation->coupleNames() }}</p>
    @if($invitation->hashtag)
        <p class="footer-hash">{{ Str::startsWith($invitation->hashtag, '#') ? $invitation->hashtag : '#' . $invitation->hashtag }}</p>
    @endif

    <div class="share">
        <a href="https://wa.me/?text={{ urlencode($invitation->coupleNames() . ' — ' . $invitation->publicUrl()) }}"
           target="_blank" rel="noopener" title="Partilhar no WhatsApp" aria-label="Partilhar no WhatsApp">&#128172;</a>
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($invitation->publicUrl()) }}"
           target="_blank" rel="noopener" title="Partilhar no Facebook" aria-label="Partilhar no Facebook">f</a>
        <button type="button" onclick="copyLink()" title="Copiar link" aria-label="Copiar link">&#128279;</button>
    </div>

    <p class="credit">
        Convite criado com <a href="{{ route('invitation.landing.pt') }}">{{ config('qrgenerate.name') }}</a>
    </p>
</footer>

@if($invitation->music_url)
    <audio id="bgm" loop preload="none" src="{{ $invitation->music_url }}"></audio>
    <button class="music" id="musicBtn" type="button" onclick="toggleMusic()"
            aria-label="Ligar ou desligar a música">&#9835;</button>
@endif

<script>
// ── Countdown ──────────────────────────────────────────────────────
(function () {
    var el = document.getElementById('cd');
    if (!el) return;

    // Parsed without a timezone so it counts down in the visitor's own clock.
    var target = new Date(el.dataset.target.replace(/-/g, '/').replace('T', ' ')).getTime();
    var done = document.getElementById('cd-done');
    var pad = function (n) { return n < 10 ? '0' + n : String(n); };

    function tick() {
        var diff = target - Date.now();
        if (diff <= 0) {
            el.style.display = 'none';
            if (done) done.style.display = 'block';
            return;
        }
        var s = Math.floor(diff / 1000);
        document.getElementById('cd-d').textContent = Math.floor(s / 86400);
        document.getElementById('cd-h').textContent = pad(Math.floor(s / 3600) % 24);
        document.getElementById('cd-m').textContent = pad(Math.floor(s / 60) % 60);
        document.getElementById('cd-s').textContent = pad(s % 60);
    }

    tick();
    setInterval(tick, 1000);
})();

// ── RSVP form ──────────────────────────────────────────────────────
function toggleAttending(yes) {
    var y = document.getElementById('choice-yes');
    var n = document.getElementById('choice-no');
    if (y) y.classList.toggle('selected', yes);
    if (n) n.classList.toggle('selected', !yes);
    var fields = document.getElementById('companion-fields');
    if (fields) fields.style.display = yes ? '' : 'none';
}

function toggleCompanionNames(value) {
    var field = document.getElementById('companion-names-field');
    if (field) field.style.display = Number(value) > 0 ? '' : 'none';
}

// ── Gallery lightbox ───────────────────────────────────────────────
function openLightbox(src) {
    var box = document.getElementById('lightbox');
    document.getElementById('lightbox-img').src = src;
    box.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('open');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') {
        var box = document.getElementById('lightbox');
        if (box && box.classList.contains('open')) closeLightbox();
    }
});

// ── Copy helpers ───────────────────────────────────────────────────
function copyText(text, button, okLabel) {
    var restore = button.innerHTML;
    var show = function () {
        button.innerHTML = okLabel;
        setTimeout(function () { button.innerHTML = restore; }, 1800);
    };

    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(show);
        return;
    }

    var ta = document.createElement('textarea');
    ta.value = text;
    ta.style.position = 'fixed';
    ta.style.opacity = '0';
    document.body.appendChild(ta);
    ta.select();
    try { document.execCommand('copy'); show(); } catch (e) { /* ignore */ }
    document.body.removeChild(ta);
}

function copyPix() {
    var key = document.getElementById('pixKey');
    if (key) copyText(key.textContent.trim(), event.currentTarget, 'Copiado!');
}

function copyLink() {
    copyText(@json($invitation->publicUrl()), event.currentTarget, '&#10003;');
}

// ── Background music ───────────────────────────────────────────────
function toggleMusic() {
    var audio = document.getElementById('bgm');
    var btn = document.getElementById('musicBtn');
    if (!audio) return;

    if (audio.paused) {
        audio.play().then(function () { btn.innerHTML = '&#9834;'; }).catch(function () {});
    } else {
        audio.pause();
        btn.innerHTML = '&#9835;';
    }
}
</script>
</body>
</html>
