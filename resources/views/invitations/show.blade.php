@php
    use Illuminate\Support\Str;

    $fonts = [
        'cormorant'  => ['Cormorant+Garamond:ital,wght@0,400;0,600;0,700;1,400', "'Cormorant Garamond', Georgia, serif"],
        'playfair'   => ['Playfair+Display:ital,wght@0,500;0,600;0,700;1,400', "'Playfair Display', Georgia, serif"],
        'lora'       => ['Lora:ital,wght@0,400;0,600;0,700;1,400', "'Lora', Georgia, serif"],
        'montserrat' => ['Montserrat:wght@300;400;600;700', "'Montserrat', Helvetica, sans-serif"],
    ];
    [$fontQuery, $fontStack] = $fonts[$invitation->font] ?? $fonts['cormorant'];

    $months   = [1=>'Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'];
    $weekdays = [0=>'Domingo','Segunda-feira','Terça-feira','Quarta-feira','Quinta-feira','Sexta-feira','Sábado'];

    $starts    = $invitation->startsAt();
    $longDate  = $weekdays[(int) $starts->format('w')] . ', ' . $starts->day . ' de ' . $months[(int) $starts->month];
    $shortTime = $invitation->event_time ? substr($invitation->event_time, 0, 5) : null;

    $isWedding = $invitation->type === 'wedding';
    $eventWord = $isWedding ? 'casamento' : 'noivado';
    $kicker    = $isWedding ? 'Vamos nos casar' : 'Vamos ficar noivos';

    $events   = $invitation->events;
    $schedule = $invitation->scheduleItems;
    $tips     = $invitation->guest_tips ?: [];
    $rides    = $invitation->ride_links ?: [];

    $hasStory     = filled($invitation->story);
    $hasDressCode = filled($invitation->dress_code) || filled($invitation->dress_code_notes);
    $hasGallery   = $invitation->photos->isNotEmpty();
    $hasGifts     = $invitation->gifts->isNotEmpty() || filled($invitation->pix_key)
                    || filled($invitation->bank_details) || filled($invitation->gift_message);
    $showRsvp     = $invitation->rsvp_enabled;
    $showGuestbook = $invitation->guestbook_enabled;

    $maxCompanions = $invitation->allow_companions ? $invitation->max_companions : 0;
    $guestCode     = $guest?->code;
    $guestLabel    = $guestName ?: 'Convidado(a) de honra';

    // The address used by the map, copy button and ride apps.
    $mainVenue = $events->firstWhere(fn ($e) => filled($e->address)) ?? $events->first();
    $fullAddress = $mainVenue
        ? trim(($mainVenue->venue_name ? $mainVenue->venue_name . ', ' : '') . $mainVenue->address)
        : null;

    // Sections that actually have content, for the nav dots and quick links.
    $nav = collect([
        ['id' => 'inicio',    'label' => 'Início',      'show' => true],
        ['id' => 'historia',  'label' => 'História',    'show' => $hasStory],
        ['id' => 'local',     'label' => 'Local',       'show' => $events->isNotEmpty()],
        ['id' => 'programa',  'label' => 'Programa',    'show' => $schedule->isNotEmpty()],
        ['id' => 'manual',    'label' => 'Manual',      'show' => count($tips) > 0 || $hasDressCode],
        ['id' => 'galeria',   'label' => 'Galeria',     'show' => $hasGallery],
        ['id' => 'presentes', 'label' => 'Presentes',   'show' => $hasGifts],
        ['id' => 'rsvp',      'label' => 'Confirmar',   'show' => $showRsvp],
        ['id' => 'recados',   'label' => 'Recados',     'show' => $showGuestbook],
    ])->where('show', true)->values();

    // Google Calendar link for the whole celebration.
    $calEnd = $starts->copy()->addHours(5);
    $calendarUrl = 'https://calendar.google.com/calendar/render?action=TEMPLATE'
        . '&text=' . urlencode(($isWedding ? 'Casamento' : 'Noivado') . ' — ' . $invitation->coupleNames())
        . '&dates=' . $starts->format('Ymd\THis') . '/' . $calEnd->format('Ymd\THis')
        . '&location=' . urlencode((string) $fullAddress)
        . '&details=' . urlencode($invitation->publicUrl($guestCode));

    $mapQuery = $fullAddress;

    $nextAfter = function (string $id) use ($nav) {
        $i = $nav->search(fn ($s) => $s['id'] === $id);
        return $i !== false && isset($nav[$i + 1]) ? $nav[$i + 1]['id'] : null;
    };
@endphp
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $invitation->coupleNames() }} — Convite de {{ ucfirst($eventWord) }}</title>
    <meta name="description" content="{{ $invitation->tagline ?: 'Convite de ' . $eventWord . ' de ' . $invitation->coupleNames() . ' — ' . $longDate . ' de ' . $starts->year }}">
    <meta name="robots" content="noindex, nofollow">
    <link rel="canonical" href="{{ $invitation->publicUrl() }}">
    <meta name="theme-color" content="{{ $invitation->primary_color }}">

    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $invitation->coupleNames() }} — Convite de {{ ucfirst($eventWord) }}">
    <meta property="og:description" content="{{ $invitation->tagline ?: $longDate . ' de ' . $starts->year }}">
    <meta property="og:url" content="{{ $invitation->publicUrl() }}">
    @if($invitation->cover_url)
        <meta property="og:image" content="{{ Str::startsWith($invitation->cover_url, 'http') ? $invitation->cover_url : url($invitation->cover_url) }}">
    @endif

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family={{ $fontQuery }}&family=Alex+Brush&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; -webkit-tap-highlight-color: transparent; }
        :root {
            --primary: {{ $invitation->primary_color }};
            --accent: {{ $invitation->accent_color }};
            --primary-soft: {{ $invitation->primary_color }}1f;
            --primary-line: {{ $invitation->primary_color }}44;
            --gold: #b6893e;
            --gold-light: #e2c78a;
            --ink: #2d2825;
            --muted: #7d766d;
            --paper: #fdfbf7;
            --paper-deep: #f4ebdd;
            --card: #ffffff;
            --line: #ece5db;
            --radius: 16px;
            --shadow: 0 22px 60px rgba(60,40,20,.18);
            --serif: {!! $fontStack !!};
            --script: 'Alex Brush', cursive;
        }
        html { scroll-behavior: smooth; scroll-padding-top: 20px; }
        body {
            font-family: var(--serif);
            background: var(--paper);
            color: var(--ink);
            line-height: 1.65;
            min-height: 100vh;
            overflow-x: hidden;
            position: relative;
            -webkit-font-smoothing: antialiased;
        }
        body::before {
            content: ''; position: fixed; inset: 0; z-index: 0; pointer-events: none;
            background-image:
                radial-gradient(circle at 12% 8%, var(--primary-soft), transparent 40%),
                radial-gradient(circle at 92% 88%, {{ $invitation->accent_color }}1f, transparent 45%);
        }
        ::selection { background: var(--primary); color: #fff; }
        svg { display: block; }

        /* ── Templates ───────────────────────────────────────────────── */
        body[data-template="botanical"] { --paper: #fbf8f2; }
        body[data-template="modern"] { --paper: #fff; --radius: 4px; }
        body[data-template="modern"] .section-title { letter-spacing: .26em; }
        body[data-template="romantic"] { --paper: #fdf9f7; }

        /* ── Petals ──────────────────────────────────────────────────── */
        #petals { position: fixed; inset: 0; width: 100%; height: 100%; pointer-events: none; z-index: 3; }

        /* ── Envelope intro ──────────────────────────────────────────── */
        #envelope-screen {
            position: fixed; inset: 0; z-index: 100;
            display: flex; align-items: center; justify-content: center;
            background: radial-gradient(circle at 50% 25%, var(--primary), var(--accent) 78%);
            transition: opacity .9s ease, visibility .9s ease;
        }
        #envelope-screen.hidden { opacity: 0; visibility: hidden; pointer-events: none; }
        .env-wrap {
            text-align: center; color: #fdf6ec; padding: 0 20px;
            width: 100%; max-width: 460px; display: flex; flex-direction: column; align-items: center;
        }
        .env-tag {
            font-size: .8rem; letter-spacing: .3em; text-transform: uppercase;
            margin-bottom: 20px; animation: envPulse 2.4s ease-in-out infinite;
        }
        @keyframes envPulse { 0%,100% { opacity: .55; } 50% { opacity: 1; } }
        .env { width: min(80vw, 320px); height: min(58vw, 220px); position: relative; margin: 0 auto 14px; cursor: pointer; }
        .env-body {
            position: absolute; inset: 0; border-radius: 14px; overflow: hidden;
            background: linear-gradient(160deg, var(--primary), var(--accent));
            border: 2px solid rgba(255,255,255,.45); box-shadow: var(--shadow);
        }
        .env-flap {
            position: absolute; top: 0; left: 0; right: 0; height: 58%;
            background: linear-gradient(160deg, var(--accent), {{ $invitation->accent_color }});
            filter: brightness(.88);
            clip-path: polygon(0 0, 100% 0, 50% 100%);
            border-radius: 14px 14px 0 0; z-index: 3;
            display: flex; align-items: flex-start; justify-content: center; padding-top: 14px;
            transform-origin: top; transition: transform 1s cubic-bezier(.6,-.3,.3,1.5);
        }
        .env-flap span { font-family: var(--script); font-size: 1.3rem; color: rgba(255,255,255,.6); }
        .env.open .env-flap { transform: rotateX(180deg); }
        .env-inner { position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; z-index: 1; }
        .env-inner svg { width: 40px; height: 40px; stroke: rgba(255,255,255,.75); }
        .env-seal {
            position: absolute; left: 50%; bottom: -26px; transform: translateX(-50%);
            width: 74px; height: 74px; border-radius: 50%; z-index: 10; cursor: pointer;
            background: radial-gradient(circle at 35% 30%, var(--primary), var(--accent) 78%);
            border: 2px solid rgba(255,255,255,.4); font: inherit;
            display: flex; flex-direction: column; align-items: center; justify-content: center;
            box-shadow: 0 10px 22px rgba(0,0,0,.35); transition: transform .3s ease;
        }
        .env-seal:hover { transform: translateX(-50%) scale(1.06) rotate(3deg); }
        .env-seal .mono { font-family: var(--script); font-size: 1.15rem; color: #fdf6ec; line-height: 1; pointer-events: none; }
        .env-seal .open-txt { font-size: .5rem; letter-spacing: .1em; text-transform: uppercase; color: rgba(255,255,255,.8); margin-top: 2px; pointer-events: none; }
        .env.open .env-seal { opacity: 0; transform: translateX(-50%) scale(.4); pointer-events: none; }
        .env-head { margin-top: 30px; }
        .env-head h2 { font-family: var(--serif); font-style: italic; font-weight: 600; font-size: 1.75rem; margin-bottom: 4px; }
        .env-head p { font-size: .95rem; letter-spacing: .3em; text-transform: uppercase; font-weight: 600; opacity: .92; }
        .env-hint {
            display: block; margin: 26px auto 0; background: none; border: none; padding: 8px 16px;
            font-family: inherit; font-size: .88rem; font-style: italic; color: #fdf6ec; opacity: .85;
            cursor: pointer; text-decoration: underline; text-underline-offset: 4px;
        }

        /* ── Gold foil + shimmer ─────────────────────────────────────── */
        .gold-foil {
            background: linear-gradient(135deg, var(--accent) 0%, var(--gold) 45%, var(--gold-light) 68%, var(--accent) 100%);
            -webkit-background-clip: text; background-clip: text;
            -webkit-text-fill-color: transparent; color: transparent;
            display: inline-block;
        }
        .shimmer { position: relative; overflow: hidden; }
        .shimmer::after {
            content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%;
            background: linear-gradient(60deg, transparent 35%, rgba(255,238,187,.45) 50%, transparent 65%);
            transform: rotate(25deg); animation: sheen 4.2s ease-in-out infinite; pointer-events: none;
        }
        @keyframes sheen {
            0% { transform: translateX(-100%) rotate(25deg); }
            22%, 100% { transform: translateX(100%) rotate(25deg); }
        }

        /* ── Music widget ────────────────────────────────────────────── */
        .music-btn {
            position: fixed; bottom: 22px; left: 20px; z-index: 60;
            width: 46px; height: 46px; border-radius: 50%; cursor: pointer; padding: 0;
            background: rgba(255,255,255,.93); backdrop-filter: blur(12px);
            border: 1.5px solid var(--primary-line); color: var(--accent);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 8px 24px rgba(0,0,0,.12); transition: all .28s cubic-bezier(.4,0,.2,1);
        }
        .music-btn:hover { transform: scale(1.08); border-color: var(--primary); }
        .music-btn.playing {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            color: #fff; border-color: transparent;
        }
        .music-btn .waves { display: none; align-items: flex-end; gap: 2.5px; height: 14px; }
        .music-btn .waves i { width: 2.5px; height: 4px; border-radius: 2px; background: currentColor; display: block; }
        .music-btn.playing .waves { display: flex; }
        .music-btn.playing .waves i:nth-child(1) { animation: waveJump .75s ease-in-out infinite alternate; }
        .music-btn.playing .waves i:nth-child(2) { animation: waveJump .60s ease-in-out .2s infinite alternate; }
        .music-btn.playing .waves i:nth-child(3) { animation: waveJump .85s ease-in-out .1s infinite alternate; }
        .music-btn.playing .waves i:nth-child(4) { animation: waveJump .65s ease-in-out .3s infinite alternate; }
        @keyframes waveJump { 0% { height: 3px; } 100% { height: 14px; } }
        .music-btn .ico { width: 18px; height: 18px; }
        .music-btn.playing .ico { display: none; }

        /* ── Nav dots ────────────────────────────────────────────────── */
        .navdots { position: fixed; right: 16px; top: 50%; transform: translateY(-50%); z-index: 40; display: flex; flex-direction: column; gap: 13px; }
        .navdots a {
            width: 9px; height: 9px; border-radius: 50%; display: block;
            background: var(--primary-soft); border: 1px solid var(--primary); transition: all .35s ease;
        }
        .navdots a.active { background: var(--primary); transform: scale(1.4); }
        @media (max-width: 720px) { .navdots { display: none; } }

        /* ── Stage, panels, reveal ───────────────────────────────────── */
        .stage { position: relative; z-index: 1; opacity: 0; transition: opacity 1s ease; }
        .stage.show { opacity: 1; }
        .panel { padding: 76px 18px; display: flex; align-items: center; justify-content: center; position: relative; overflow: hidden; }
        .panel-inner { width: min(92vw, 620px); text-align: center; position: relative; z-index: 2; --enter: translateY(30px); }
        .panel-inner > * {
            opacity: 0; transform: var(--enter);
            transition: opacity .65s cubic-bezier(.4,0,.2,1), transform .65s cubic-bezier(.4,0,.2,1);
            will-change: opacity, transform;
        }
        .panel-inner.reveal > * { opacity: 1; transform: none; }
        .panel-inner.reveal > *:nth-child(1) { transition-delay: .04s; }
        .panel-inner.reveal > *:nth-child(2) { transition-delay: .12s; }
        .panel-inner.reveal > *:nth-child(3) { transition-delay: .20s; }
        .panel-inner.reveal > *:nth-child(4) { transition-delay: .28s; }
        .panel-inner.reveal > *:nth-child(5) { transition-delay: .36s; }
        .panel-inner.reveal > *:nth-child(6) { transition-delay: .44s; }
        .panel-inner.reveal > *:nth-child(7) { transition-delay: .52s; }
        .panel-inner.reveal > *:nth-child(8) { transition-delay: .60s; }
        .panel-inner.dir-left { --enter: translateX(-38px); }
        .panel-inner.dir-right { --enter: translateX(38px); }
        .panel-inner.dir-scale { --enter: scale(.86); }
        .blob { position: absolute; border-radius: 50%; filter: blur(4px); opacity: .32; z-index: 1; pointer-events: none; will-change: transform; }

        /* ── Mascot ──────────────────────────────────────────────────── */
        .mascot { width: 94px; height: auto; margin: 0 auto 6px; opacity: 0; transform: translateY(-60px); }
        .panel-inner.reveal > .mascot { animation: mascotIn .85s cubic-bezier(.34,1.56,.64,1) forwards; }
        @keyframes mascotIn {
            0%   { transform: translateY(-60px) scale(.9); opacity: 0; }
            50%  { transform: translateY(12px) scale(1.04); opacity: 1; }
            70%  { transform: translateY(-8px) scale(.99); }
            87%  { transform: translateY(4px) scale(1.01); }
            100% { transform: translateY(0) scale(1); opacity: 1; }
        }

        /* ── Shared bits ─────────────────────────────────────────────── */
        .icon-badge {
            width: 52px; height: 52px; border-radius: 50%; margin: 0 auto 14px;
            background: var(--primary-soft); border: 1px solid var(--primary-line);
            display: flex; align-items: center; justify-content: center;
        }
        .icon-badge svg { width: 22px; height: 22px; stroke: var(--primary); fill: none; stroke-width: 1.5; }
        .badge-tag {
            display: inline-block; padding: 7px 20px; border-radius: 999px; margin-bottom: 18px;
            background: var(--primary-soft); color: var(--accent);
            font-weight: 600; font-size: .78rem; letter-spacing: .22em; text-transform: uppercase;
        }
        .names { font-weight: 700; font-size: clamp(2.5rem, 10vw, 3.9rem); line-height: 1.06; margin-bottom: 6px; }
        .names .amp { font-family: var(--script); color: var(--primary); font-size: .62em; padding: 0 8px; font-weight: 400; }
        .divider { width: 64px; height: 1.5px; background: var(--primary); opacity: .4; margin: 20px auto; border: none; }
        .quote { font-style: italic; font-size: 1.2rem; line-height: 1.7; color: #544a3c; max-width: 480px; margin: 0 auto; }
        .section-title { font-size: 12px; letter-spacing: .3em; text-transform: uppercase; color: var(--primary); font-weight: 600; }
        .title { font-weight: 600; font-size: clamp(1.7rem, 5.5vw, 2.1rem); margin-bottom: 2px; }
        .script-sub { font-family: var(--script); font-size: 1.9rem; color: var(--primary); margin-bottom: 18px; line-height: 1.2; }

        /* ── Greeting ────────────────────────────────────────────────── */
        .greeting {
            background: var(--card); border: 1px solid var(--primary-line); border-radius: var(--radius);
            padding: 22px 24px; text-align: center; max-width: 620px; margin: 0 auto;
            box-shadow: 0 12px 34px rgba(0,0,0,.08);
        }
        .greeting-label { font-size: 11px; letter-spacing: .24em; text-transform: uppercase; color: var(--muted); }
        .greeting-name { font-family: var(--script); font-size: clamp(1.9rem, 7vw, 2.5rem); color: var(--primary); line-height: 1.25; }
        .greeting-note { font-size: 1rem; color: var(--muted); margin-top: 8px; }

        /* ── Countdown ───────────────────────────────────────────────── */
        .cd-wrap { background: var(--primary-soft); border: 1px solid var(--primary-line); border-radius: 20px; padding: 22px 18px; }
        .cd-label { font-size: .72rem; letter-spacing: .2em; text-transform: uppercase; color: var(--accent); font-weight: 600; margin-bottom: 14px; }
        .countdown { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
        .cd-box { width: 76px; background: #fff; border-radius: 14px; padding: 12px 0; border: 1px solid var(--line); box-shadow: 0 4px 10px rgba(0,0,0,.05); }
        .cd-num { font-weight: 700; font-size: 1.7rem; color: var(--accent); line-height: 1; font-variant-numeric: tabular-nums; }
        .cd-lbl { font-size: .62rem; letter-spacing: .16em; text-transform: uppercase; color: var(--muted); margin-top: 3px; }
        .cd-done { font-size: 1.2rem; color: var(--primary); font-style: italic; }

        /* ── Date row ────────────────────────────────────────────────── */
        .dt-row {
            display: flex; gap: 24px; justify-content: center; flex-wrap: wrap;
            border-top: 1px solid var(--primary-line); border-bottom: 1px solid var(--primary-line); padding: 22px 0;
        }
        .dt-item svg { width: 24px; height: 24px; stroke: var(--primary); fill: none; stroke-width: 1.4; margin: 0 auto 6px; }
        .dt-item .big { font-weight: 600; font-size: 1.2rem; }
        .dt-item .small { font-size: .7rem; letter-spacing: .12em; text-transform: uppercase; color: var(--accent); margin-top: 2px; }

        /* ── Buttons ─────────────────────────────────────────────────── */
        .btn {
            display: inline-flex; align-items: center; justify-content: center; gap: 8px;
            padding: 12px 24px; border-radius: 999px; font-family: inherit;
            font-weight: 600; font-size: .85rem; letter-spacing: .1em; text-transform: uppercase;
            text-decoration: none; cursor: pointer; border: 1.5px solid var(--primary);
            background: var(--primary); color: #fff; transition: filter .2s, transform .2s;
        }
        .btn:hover { filter: brightness(1.08); transform: translateY(-2px); }
        .btn svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 1.7; }
        .btn-ghost { background: #fff; color: var(--accent); }
        .btn-ghost:hover { background: var(--primary-soft); }
        .btn-gold { background: linear-gradient(135deg, var(--gold), var(--accent)); border-color: transparent; }
        .btn-wide { width: 100%; }
        .btn-row { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }

        /* ── Quick nav + next chevron ────────────────────────────────── */
        .quicknav { display: flex; gap: 9px; justify-content: center; flex-wrap: wrap; }
        .quicknav a {
            display: inline-flex; align-items: center; gap: 6px; padding: 9px 16px; border-radius: 999px;
            background: #fff; border: 1px solid var(--primary-line); color: var(--accent);
            font-weight: 600; font-size: .82rem; text-decoration: none; transition: all .25s ease;
        }
        .quicknav a:hover { background: var(--primary); color: #fff; transform: translateY(-2px); }
        .next-btn {
            width: 46px; height: 46px; border-radius: 50%; margin: 34px auto 0;
            border: 1px solid var(--primary-line); background: #fff; color: var(--primary);
            display: flex; align-items: center; justify-content: center; text-decoration: none;
            box-shadow: 0 6px 16px rgba(0,0,0,.06); animation: nextBob 2.2s ease-in-out infinite;
            transition: background .25s, color .25s;
        }
        .next-btn:hover { background: var(--primary); color: #fff; }
        .next-btn svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 2; }
        @keyframes nextBob { 0%,100% { transform: translateY(0); } 50% { transform: translateY(6px); } }

        /* ── Cards ───────────────────────────────────────────────────── */
        .card { background: var(--card); border: 1px solid var(--line); border-radius: var(--radius); padding: 22px 24px; }
        .card + .card { margin-top: 14px; }
        .addr-card { max-width: 440px; margin: 0 auto; }
        .addr-card .place { font-weight: 700; font-size: 1.2rem; margin-bottom: 4px; }
        .addr-card .land { font-weight: 600; font-size: 1.02rem; color: var(--accent); margin-bottom: 10px; }
        .addr-card .note {
            font-size: .9rem; color: var(--muted); background: var(--primary-soft);
            border: 1px solid var(--primary-line); border-radius: 12px; padding: 10px 12px; line-height: 1.5;
        }
        .addr-card .meta { font-size: .92rem; color: #4a453e; margin-top: 10px; }
        .map-wrap { border-radius: var(--radius); overflow: hidden; border: 1px solid var(--primary-line); }
        .map-wrap iframe { display: block; width: 100%; height: 230px; border: 0; }

        /* ── Ride concierge ──────────────────────────────────────────── */
        .ride-card { max-width: 440px; margin: 0 auto; text-align: center; }
        .ride-title { font-weight: 700; font-size: 1.05rem; margin-bottom: 4px; }
        .ride-desc { font-size: .85rem; color: var(--muted); margin-bottom: 14px; }
        .ride-links { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; }
        .ride-links a {
            display: inline-flex; align-items: center; gap: 7px; padding: 10px 16px; border-radius: 12px;
            background: var(--primary); color: #fff; font-weight: 700; font-size: .85rem;
            text-decoration: none; transition: all .25s ease;
        }
        .ride-links a:hover { filter: brightness(1.1); transform: translateY(-2px); }
        .ride-links svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 1.8; }

        /* ── Timeline ────────────────────────────────────────────────── */
        .timeline { text-align: left; max-width: 440px; margin: 0 auto; display: flex; flex-direction: column; gap: 12px; }
        .t-item { display: flex; align-items: flex-start; gap: 15px; background: var(--card); border: 1px solid var(--line); border-radius: var(--radius); padding: 14px 16px; }
        .t-time {
            flex: 0 0 auto; background: var(--primary-soft); color: var(--accent);
            font-weight: 700; font-size: .8rem; padding: 6px 12px; border-radius: 999px; white-space: nowrap;
        }
        .t-item h4 { font-weight: 700; font-size: 1.06rem; margin-bottom: 2px; }
        .t-item p { font-size: .88rem; color: var(--muted); line-height: 1.45; }

        /* ── Guest manual ────────────────────────────────────────────── */
        .tips-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; max-width: 440px; margin: 0 auto; }
        .tip-card { background: var(--card); border: 1px solid var(--line); border-radius: var(--radius); padding: 18px 10px 16px; text-align: center; }
        .tip-card .icon-badge { width: 44px; height: 44px; margin-bottom: 10px; }
        .tip-card .icon-badge svg { width: 18px; height: 18px; }
        .tip-card p { font-size: .84rem; font-weight: 600; line-height: 1.34; }
        @media (max-width: 380px) { .tip-card p { font-size: .78rem; } }

        /* ── Story ───────────────────────────────────────────────────── */
        .story { display: grid; gap: 26px; align-items: center; }
        @media (min-width: 740px) { .story.has-photo { grid-template-columns: 1fr 1fr; } }
        .story-photo { width: 100%; border-radius: var(--radius); object-fit: cover; aspect-ratio: 4/5; box-shadow: 0 10px 30px rgba(0,0,0,.1); }
        .story-text { white-space: pre-line; font-size: 1.05rem; color: #4a453e; text-align: left; }

        /* ── Gallery ─────────────────────────────────────────────────── */
        .gallery { display: grid; grid-template-columns: repeat(auto-fill, minmax(150px, 1fr)); gap: 10px; }
        .gallery figure { margin: 0; }
        .gallery img {
            width: 100%; aspect-ratio: 1; object-fit: cover; border-radius: 10px; display: block;
            cursor: zoom-in; transition: transform .25s, box-shadow .25s;
        }
        .gallery img:hover { transform: scale(1.02); box-shadow: 0 8px 22px rgba(0,0,0,.14); }
        .gallery figcaption { font-size: .76rem; color: var(--muted); margin-top: 5px; }
        .lightbox { position: fixed; inset: 0; z-index: 120; background: rgba(0,0,0,.92); display: none; align-items: center; justify-content: center; padding: 20px; }
        .lightbox.open { display: flex; }
        .lightbox img { max-width: 100%; max-height: 90vh; border-radius: 8px; }
        .lightbox-close { position: absolute; top: 14px; right: 18px; background: none; border: none; color: #fff; font-size: 34px; cursor: pointer; line-height: 1; }

        /* ── Gifts ───────────────────────────────────────────────────── */
        .pix-box { background: var(--primary-soft); border: 1px dashed var(--primary-line); border-radius: 12px; padding: 18px; text-align: center; }
        .pix-key {
            font-family: ui-monospace, Menlo, Consolas, monospace; font-size: .9rem; word-break: break-all;
            background: #fff; border: 1px solid var(--line); border-radius: 8px; padding: 10px 12px; margin: 10px 0;
        }
        .gift-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 14px; }
        .gift { background: var(--card); border: 1px solid var(--line); border-radius: 12px; padding: 14px; display: flex; flex-direction: column; gap: 8px; text-align: left; }
        .gift img { width: 100%; aspect-ratio: 4/3; object-fit: cover; border-radius: 8px; }
        .gift-name { font-weight: 700; font-size: 1.02rem; }
        .gift-desc { font-size: .86rem; color: var(--muted); }
        .gift-price { font-weight: 700; color: var(--primary); }
        .gift-taken { font-size: .82rem; color: var(--muted); font-style: italic; margin-top: auto; }
        .gift form { margin-top: auto; display: flex; gap: 6px; }
        .gift form input { flex: 1; min-width: 0; }

        /* ── Forms ───────────────────────────────────────────────────── */
        label.fl { display: block; font-size: .75rem; letter-spacing: .1em; text-transform: uppercase; color: var(--ink); font-weight: 600; margin-bottom: 6px; }
        input[type=text], input[type=email], input[type=tel], select, textarea {
            width: 100%; padding: 11px 14px; border: 1.5px solid var(--line); border-radius: 12px;
            font-size: 1rem; font-family: inherit; background: var(--paper); color: var(--ink);
        }
        input:focus, select:focus, textarea:focus { outline: none; border-color: var(--primary); box-shadow: 0 0 0 3px var(--primary-soft); }
        textarea { resize: vertical; min-height: 64px; }
        .field { margin-bottom: 16px; text-align: left; }
        .field-row { display: grid; gap: 15px; }
        @media (min-width: 620px) { .field-row.two { grid-template-columns: 1fr 1fr; } }
        .choice-row { display: flex; gap: 10px; }
        .choice { flex: 1; }
        .choice input { position: absolute; opacity: 0; width: 0; height: 0; }
        .choice span {
            display: block; text-align: center; padding: 12px 6px; border-radius: 12px; cursor: pointer;
            border: 1.5px solid var(--line); font-weight: 600; background: #fff; transition: all .2s ease;
        }
        .choice input:checked + span { background: var(--primary); color: #fff; border-color: var(--primary); }
        .rsvp-panel { background: var(--card); border: 2px solid var(--primary-line); border-radius: 22px; padding: 32px 24px; box-shadow: var(--shadow); }
        .rsvp-note { display: inline-block; font-size: .74rem; font-weight: 600; color: var(--accent); background: var(--primary-soft); padding: 6px 16px; border-radius: 999px; }
        .alert { border-radius: 12px; padding: 13px 15px; font-size: .95rem; }
        .alert-ok { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        .alert-info { background: var(--primary-soft); border: 1px solid var(--primary-line); color: var(--accent); }
        .alert-bad { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }

        /* ── Guestbook ───────────────────────────────────────────────── */
        .note { background: var(--card); border: 1px solid var(--line); border-left: 3px solid var(--primary); border-radius: 10px; padding: 14px 16px; text-align: left; }
        .note + .note { margin-top: 10px; }
        .note-name { font-weight: 700; }
        .note-when { font-size: .76rem; color: var(--muted); font-weight: 400; }
        .note-text { margin-top: 6px; white-space: pre-line; }

        /* ── Footer ──────────────────────────────────────────────────── */
        .footer { text-align: center; padding: 46px 20px 56px; border-top: 1px solid var(--line); }
        .footer-names { font-family: var(--script); font-size: 2.4rem; color: var(--primary); line-height: 1.2; }
        .footer-hash { font-size: .9rem; color: var(--muted); letter-spacing: .06em; margin-top: 4px; }
        .share { display: flex; gap: 10px; justify-content: center; flex-wrap: wrap; margin-top: 18px; }
        .share a, .share button {
            width: 42px; height: 42px; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;
            background: var(--primary-soft); color: var(--primary); border: 1px solid var(--primary-line);
            text-decoration: none; font-size: 17px; cursor: pointer; font-family: inherit;
        }
        .share a:hover, .share button:hover { background: var(--primary); color: #fff; }
        .credit { font-size: .78rem; color: #b3aba0; margin-top: 24px; }
        .credit a { color: var(--primary); text-decoration: none; }

        /* ── Toast + confetti ────────────────────────────────────────── */
        #toast {
            position: fixed; bottom: 84px; left: 50%; transform: translateX(-50%) translateY(20px);
            background: var(--ink); color: #fff; font-size: .88rem; padding: 11px 20px; border-radius: 999px;
            z-index: 200; opacity: 0; pointer-events: none; transition: opacity .3s, transform .3s;
            display: flex; align-items: center; gap: 8px; max-width: 90vw;
        }
        #toast.show { opacity: 1; transform: translateX(-50%) translateY(0); }
        #confetti { position: fixed; inset: 0; width: 100%; height: 100%; pointer-events: none; z-index: 300; }

        /* ── Printable keepsake card ─────────────────────────────────── */
        .keepsake {
            position: relative; display: flex; max-width: 480px; margin: 0 auto;
            background: #faf9f5; border: 1px solid var(--primary-line); border-radius: var(--radius);
            overflow: hidden; box-shadow: 0 16px 40px rgba(45,40,37,.16); text-align: center;
        }
        .keepsake-text { flex: 1; padding: 30px 20px 26px; display: flex; flex-direction: column; gap: 9px; align-items: center; }
        .keepsake-side {
            width: 120px; flex: 0 0 120px;
            background: linear-gradient(170deg, var(--primary), var(--accent));
            background-size: cover; background-position: center;
        }
        .ks-tag { font-size: 10px; letter-spacing: .32em; text-transform: uppercase; color: var(--muted); font-weight: 600; }
        .ks-name { font-family: var(--script); font-size: 2.6rem; color: var(--gold); line-height: .95; }
        .ks-and { font-size: .72rem; letter-spacing: .36em; text-transform: uppercase; color: var(--muted); font-weight: 600; }
        .ks-date-row { display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; }
        .ks-line { flex: 1; height: 1px; background: var(--gold); opacity: .45; }
        .ks-side-txt { font-size: 9px; letter-spacing: .18em; text-transform: uppercase; color: #6a6255; font-weight: 600; white-space: nowrap; }
        .ks-day { font-weight: 700; font-size: 2.1rem; line-height: 1; }
        .ks-month, .ks-year { font-size: 9.5px; letter-spacing: .28em; text-transform: uppercase; color: #7a7062; font-weight: 700; }
        .ks-body { font-size: 10.5px; letter-spacing: .08em; text-transform: uppercase; color: #70685c; line-height: 1.5; max-width: 250px; }
        .ks-guest-label { font-size: 8px; letter-spacing: .24em; text-transform: uppercase; color: var(--muted); font-weight: 600; }
        .ks-guest { font-weight: 700; font-size: 1.1rem; line-height: 1.25; }
        .ks-loc { font-size: 9.5px; text-transform: uppercase; color: #7a7062; line-height: 1.5; }
        .ks-foot { font-family: var(--script); font-size: 1.5rem; color: var(--gold); line-height: 1; }
        @media (max-width: 430px) {
            .keepsake-side { width: 86px; flex: 0 0 86px; }
            .keepsake-text { padding: 22px 12px 20px; }
            .ks-name { font-size: 2.1rem; }
            .ks-day { font-size: 1.7rem; }
        }

        @media (max-width: 480px) {
            .panel { padding: 56px 16px; }
            .card { padding: 18px; }
            .rsvp-panel { padding: 24px 16px; }
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: .01ms !important; animation-iteration-count: 1 !important; transition-duration: .01ms !important; }
            .panel-inner > * { opacity: 1; transform: none; }
        }

        /* Printing gives the guest a paper keepsake of just the card. */
        @media print {
            @page { size: A5 portrait; margin: 0; }
            body { background: #fff; }
            body::before, #petals, #envelope-screen, .navdots, .music-btn, #toast, #confetti,
            .stage > .panel, .footer, .lightbox { display: none !important; }
            #keepsake-panel { display: flex !important; padding: 0; min-height: 100vh; }
            #keepsake-panel .panel-inner > * { opacity: 1 !important; transform: none !important; }
            #keepsake-panel .no-print { display: none !important; }
            .keepsake { box-shadow: none; border-color: var(--gold); max-width: 100%; }
            .stage { opacity: 1 !important; }
        }
    </style>
</head>
<body data-template="{{ $invitation->template }}">

@if($invitation->petals_enabled)
    <canvas id="petals"></canvas>
@endif

@if($invitation->music_url)
    <audio id="bgm" loop preload="none" src="{{ $invitation->music_url }}"></audio>
@endif

{{-- Reusable couple illustration --}}
@if($invitation->mascot_enabled)
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
    <symbol id="couple" viewBox="0 0 280 190">
        <circle cx="140" cy="95" r="72" fill="var(--primary)" opacity=".14"/>
        {{-- left figure --}}
        <path d="M70 178C70 138 85 118 105 118C125 118 140 138 140 178Z" fill="var(--accent)"/>
        <path d="M95 118L105 143L115 118Z" fill="#fdfbf7"/>
        <circle cx="105" cy="92" r="22" fill="#8a5a35"/>
        <path d="M83 87C83 67 127 67 127 87C127 75 83 75 83 87Z" fill="#241a10"/>
        <path d="M100 99Q105 104 110 99" stroke="#fff" stroke-width="2" stroke-linecap="round" fill="none"/>
        <circle cx="98" cy="89" r="2" fill="#241a10"/><circle cx="112" cy="89" r="2" fill="#241a10"/>
        {{-- right figure --}}
        <path d="M140 178C140 138 155 116 175 116C195 116 210 138 210 178Z" fill="#fdfbf7" stroke="var(--primary)" stroke-width="1"/>
        <path d="M165 118Q175 128 185 118" stroke="var(--gold)" stroke-width="2" fill="none"/>
        <circle cx="175" cy="92" r="20" fill="#8a5a35"/>
        <path d="M153 92C150 67 200 67 197 92C202 82 198 62 175 62C152 62 148 82 153 92Z" fill="#241a10"/>
        <circle cx="190" cy="77" r="5" fill="var(--primary)"/>
        <path d="M170 99Q175 104 180 99" stroke="#fff" stroke-width="2" stroke-linecap="round" fill="none"/>
        <circle cx="168" cy="89" r="2" fill="#241a10"/><circle cx="182" cy="89" r="2" fill="#241a10"/>
        {{-- ring + heart --}}
        <circle cx="140" cy="122" r="8" stroke="var(--gold)" stroke-width="2.5" fill="none"/>
        <path d="M140 110L143 114L140 117L137 114Z" fill="var(--gold-light)"/>
        <path d="M138 58C138 53 130 53 130 60C130 68 138 73 138 76C138 73 146 68 146 60C146 53 138 53 138 58Z" fill="var(--primary)"/>
    </symbol>
</svg>
@endif

{{-- ── Envelope intro ──────────────────────────────────────────────── --}}
@if($invitation->envelope_enabled)
<div id="envelope-screen">
    <div class="env-wrap">
        <p class="env-tag">{{ $guestName ? 'Tens um convite especial' : 'Convite especial' }}</p>
        <div class="env" id="envelope">
            <div class="env-body"></div>
            <div class="env-inner">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.2">
                    <path d="M12 22C12 22 12 13 18 8C19.5 6.5 21 7 21 7C21 7 21.5 8.5 20 10C15 16 12 22 12 22Z"/>
                    <path d="M12 22C12 22 12 13 6 8C4.5 6.5 3 7 3 7C3 7 2.5 8.5 4 10C9 16 12 22 12 22Z"/>
                    <path d="M12 22V2"/>
                </svg>
            </div>
            <div class="env-flap"><span>{{ $invitation->monogramText() }}</span></div>
            <button type="button" class="env-seal" id="envSeal" aria-label="Abrir convite">
                <span class="mono">{{ $invitation->monogramText() }}</span>
                <span class="open-txt">Abrir</span>
            </button>
        </div>
        <div class="env-head">
            <h2>{{ $isWedding ? 'Casamento' : 'Festa de Noivado' }}</h2>
            <p>{{ $invitation->coupleNames() }}</p>
        </div>
        <button type="button" class="env-hint" id="envHint">Toque para abrir o convite</button>
    </div>
</div>
@endif

{{-- ── Music ───────────────────────────────────────────────────────── --}}
@if($invitation->music_url)
<button type="button" class="music-btn" id="musicBtn" title="Tocar ou pausar a música" aria-label="Tocar ou pausar a música">
    <span class="waves"><i></i><i></i><i></i><i></i></span>
    <svg class="ico" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
        <path d="M9 18V5l12-2v13"/><circle cx="6" cy="18" r="3"/><circle cx="18" cy="16" r="3"/>
    </svg>
</button>
@endif

{{-- ── Nav dots ────────────────────────────────────────────────────── --}}
@if($nav->count() > 1)
<nav class="navdots" aria-label="Secções do convite">
    @foreach($nav as $i => $section)
        <a href="#{{ $section['id'] }}" data-target="{{ $section['id'] }}"
           class="{{ $i === 0 ? 'active' : '' }}" title="{{ $section['label'] }}"></a>
    @endforeach
</nav>
@endif

<div class="stage {{ $invitation->envelope_enabled ? '' : 'show' }}" id="stage">

    {{-- ── Hero ────────────────────────────────────────────────────── --}}
    <section class="panel" id="inicio">
        <div class="blob" data-speed=".15" style="width:260px;height:260px;top:-60px;right:-80px;background:radial-gradient(circle,var(--primary),transparent 70%);"></div>
        <div class="blob" data-speed=".08" style="width:180px;height:180px;bottom:-40px;left:-60px;background:radial-gradient(circle,var(--gold-light),transparent 70%);"></div>
        <div class="panel-inner reveal">
            @if($invitation->mascot_enabled)
                <svg class="mascot"><use href="#couple"/></svg>
            @endif
            <span class="badge-tag">{{ $kicker }}</span>
            <h1 class="names">
                <span class="gold-foil">{{ $invitation->partner_one_name }}</span>
                @if($invitation->partner_two_name)
                    <span class="amp">&amp;</span><span class="gold-foil">{{ $invitation->partner_two_name }}</span>
                @endif
            </h1>
            <hr class="divider">
            @if($invitation->tagline)
                <p class="quote">“{{ $invitation->tagline }}”</p>
            @endif

            @if($invitation->countdown_enabled)
                <div class="cd-wrap">
                    <p class="cd-label">{{ $invitation->isPast() ? 'Obrigado por celebrar com a gente' : 'Contagem decrescente' }}</p>
                    <div class="countdown" id="cd" data-target="{{ $starts->format('Y-m-d\TH:i:s') }}">
                        <div class="cd-box"><div class="cd-num" id="cd-d">--</div><div class="cd-lbl">Dias</div></div>
                        <div class="cd-box"><div class="cd-num" id="cd-h">--</div><div class="cd-lbl">Horas</div></div>
                        <div class="cd-box"><div class="cd-num" id="cd-m">--</div><div class="cd-lbl">Min</div></div>
                        <div class="cd-box"><div class="cd-num" id="cd-s">--</div><div class="cd-lbl">Seg</div></div>
                    </div>
                    <p class="cd-done" id="cd-done" style="display:none;">O grande dia chegou! &#128141;</p>
                </div>
            @endif

            <div class="dt-row">
                <div class="dt-item">
                    <svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 10h18"/></svg>
                    <div class="big">{{ $longDate }}</div>
                    <div class="small">Ano de {{ $starts->year }}</div>
                </div>
                @if($shortTime)
                    <div class="dt-item">
                        <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg>
                        <div class="big">Início às {{ $shortTime }}</div>
                        <div class="small">Pontualidade agradecida</div>
                    </div>
                @endif
            </div>

            <div class="btn-row">
                <a class="btn" href="{{ $calendarUrl }}" target="_blank" rel="noopener">
                    <svg viewBox="0 0 24 24"><rect x="3" y="5" width="18" height="16" rx="2"/><path d="M8 3v4M16 3v4M3 10h18M12 14v4M10 16h4"/></svg>
                    Guardar data
                </a>
                <a class="btn btn-gold shimmer" href="#convite">
                    <svg viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                    Baixar convite
                </a>
            </div>

            @if($nav->count() > 1)
                <div class="quicknav">
                    @foreach($nav->skip(1) as $section)
                        <a href="#{{ $section['id'] }}">{{ $section['label'] }}</a>
                    @endforeach
                </div>
            @endif

            @if($next = $nextAfter('inicio'))
                <a href="#{{ $next }}" class="next-btn" aria-label="Ver a secção seguinte">
                    <svg viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                </a>
            @endif
        </div>
    </section>

    {{-- ── Personalised greeting ───────────────────────────────────── --}}
    @if($guestName || $invitation->welcome_message)
        <section class="panel" style="padding-top:0;padding-bottom:36px;">
            <div class="panel-inner dir-scale">
                <div class="greeting">
                    @if($guestName)
                        <p class="greeting-label">Convite especial para</p>
                        <p class="greeting-name">{{ $guestName }}</p>
                    @endif
                    <p class="greeting-note">
                        {{ $invitation->welcome_message ?: 'É com muita alegria que convidamos você para celebrar este dia conosco.' }}
                    </p>
                </div>
            </div>
        </section>
    @endif

    {{-- ── Story ───────────────────────────────────────────────────── --}}
    @if($hasStory)
    <section class="panel" id="historia">
        <div class="blob" data-speed=".12" style="width:210px;height:210px;top:8%;left:-70px;background:radial-gradient(circle,var(--primary),transparent 70%);"></div>
        <div class="panel-inner dir-left">
            @if($invitation->mascot_enabled)<svg class="mascot"><use href="#couple"/></svg>@endif
            <div class="icon-badge">
                <svg viewBox="0 0 24 24"><path d="M20.8 4.6a5.5 5.5 0 0 0-7.8 0L12 5.7l-1-1.1a5.5 5.5 0 0 0-7.8 7.8l1 1L12 21l7.8-7.8 1-1a5.5 5.5 0 0 0 0-7.8Z"/></svg>
            </div>
            <h2 class="title">Nossa história</h2>
            <p class="script-sub">Como tudo começou</p>
            <div class="story {{ $invitation->couple_photo_url ? 'has-photo' : '' }}">
                @if($invitation->couple_photo_url)
                    <img class="story-photo" src="{{ $invitation->couple_photo_url }}" alt="{{ $invitation->coupleNames() }}" loading="lazy">
                @endif
                <div class="story-text">{{ $invitation->story }}</div>
            </div>
            @if($next = $nextAfter('historia'))
                <a href="#{{ $next }}" class="next-btn" aria-label="Ver a secção seguinte"><svg viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg></a>
            @endif
        </div>
    </section>
    @endif

    {{-- ── Venue ───────────────────────────────────────────────────── --}}
    @if($events->isNotEmpty())
    <section class="panel" id="local">
        <div class="blob" data-speed=".18" style="width:170px;height:170px;bottom:0;right:-50px;background:radial-gradient(circle,var(--gold-light),transparent 70%);"></div>
        <div class="panel-inner dir-left">
            @if($invitation->mascot_enabled)<svg class="mascot"><use href="#couple"/></svg>@endif
            <div class="icon-badge">
                <svg viewBox="0 0 24 24"><path d="M12 21s-7-6.5-7-12a7 7 0 0 1 14 0c0 5.5-7 12-7 12Z"/><circle cx="12" cy="9" r="2.5"/></svg>
            </div>
            <h2 class="title">{{ $events->count() > 1 ? 'A celebração' : 'Local da festa' }}</h2>
            <p class="script-sub">Onde vamos festejar</p>

            @foreach($events as $event)
                @php
                    $kinds = ['ceremony' => 'Cerimónia', 'reception' => 'Recepção', 'party' => 'Festa', 'other' => 'Programa'];
                    $eDate = $event->event_date ?: $invitation->event_date;
                    $eTime = $event->event_time ?: $invitation->event_time;
                @endphp
                <div class="card addr-card">
                    <p class="section-title">{{ $kinds[$event->kind] ?? 'Programa' }}</p>
                    <p class="place">{{ $event->venue_name ?: $event->title }}</p>
                    @if($event->venue_name && $event->title !== $event->venue_name)
                        <p class="land">{{ $event->title }}</p>
                    @endif
                    @if($event->address)<p class="land">{{ $event->address }}</p>@endif
                    <p class="meta">
                        {{ $weekdays[(int) $eDate->format('w')] }}, {{ $eDate->day }} de {{ $months[(int) $eDate->month] }}
                        @if($eTime) &middot; {{ substr($eTime, 0, 5) }} @endif
                    </p>
                    @if($event->notes)<p class="note" style="margin-top:10px;">{{ $event->notes }}</p>@endif
                </div>
            @endforeach

            @if($mapQuery)
                <div class="map-wrap">
                    <iframe loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Mapa do local"
                            src="https://www.google.com/maps?q={{ urlencode($mapQuery) }}&output=embed"></iframe>
                </div>
            @endif

            <div class="btn-row">
                @if($mainVenue && $mainVenue->mapsLink())
                    <a class="btn" href="{{ $mainVenue->mapsLink() }}" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24"><path d="M3 11l18-8-8 18-2-8-8-2Z"/></svg>
                        Google Maps
                    </a>
                @endif
                @if($fullAddress)
                    <a class="btn btn-ghost" href="https://maps.apple.com/?q={{ urlencode($fullAddress) }}" target="_blank" rel="noopener">
                        <svg viewBox="0 0 24 24"><path d="M12 2a8 8 0 0 0-8 8c0 5.25 8 12 8 12s8-6.75 8-12a8 8 0 0 0-8-8z"/><circle cx="12" cy="10" r="3"/></svg>
                        Apple Maps
                    </a>
                    <button type="button" class="btn btn-ghost" onclick="copyAddress(this)">
                        <svg viewBox="0 0 24 24"><rect x="8" y="8" width="12" height="12" rx="2"/><path d="M4 16V4h12"/></svg>
                        <span>Copiar endereço</span>
                    </button>
                @endif
            </div>

            @if(count($rides) > 0)
                <div class="card ride-card">
                    <p class="ride-title">Vai de táxi ou app de transporte?</p>
                    <p class="ride-desc">Peça a sua viagem já com o destino certo:</p>
                    <div class="ride-links">
                        @foreach($rides as $ride)
                            <a href="{{ $ride['url'] }}" target="_blank" rel="noopener">
                                <svg viewBox="0 0 24 24"><path d="M5 17h14l-1.5-6H6.5L5 17Z"/><circle cx="8" cy="19" r="1.6"/><circle cx="16" cy="19" r="1.6"/><path d="M8 11V8h8v3"/></svg>
                                {{ $ride['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            @if($next = $nextAfter('local'))
                <a href="#{{ $next }}" class="next-btn" aria-label="Ver a secção seguinte"><svg viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg></a>
            @endif
        </div>
    </section>
    @endif

    {{-- ── Programme timeline ──────────────────────────────────────── --}}
    @if($schedule->isNotEmpty())
    <section class="panel" id="programa">
        <div class="blob" data-speed=".14" style="width:200px;height:200px;top:-30px;right:-60px;background:radial-gradient(circle,var(--primary),transparent 70%);"></div>
        <div class="panel-inner dir-right">
            @if($invitation->mascot_enabled)<svg class="mascot"><use href="#couple"/></svg>@endif
            <div class="icon-badge"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3 3"/></svg></div>
            <h2 class="title">Programa da noite</h2>
            <p class="script-sub">Momentos de alegria</p>
            <div class="timeline">
                @foreach($schedule as $item)
                    <div class="t-item">
                        @if($item->time)<span class="t-time">{{ substr($item->time, 0, 5) }}</span>@endif
                        <div>
                            <h4>{{ $item->title }}</h4>
                            @if($item->description)<p>{{ $item->description }}</p>@endif
                        </div>
                    </div>
                @endforeach
            </div>
            @if($next = $nextAfter('programa'))
                <a href="#{{ $next }}" class="next-btn" aria-label="Ver a secção seguinte"><svg viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg></a>
            @endif
        </div>
    </section>
    @endif

    {{-- ── Guest manual + dress code ───────────────────────────────── --}}
    @if(count($tips) > 0 || $hasDressCode)
    <section class="panel" id="manual">
        <div class="blob" data-speed=".11" style="width:210px;height:210px;bottom:-40px;right:-60px;background:radial-gradient(circle,var(--gold-light),transparent 70%);"></div>
        <div class="panel-inner dir-left">
            @if($invitation->mascot_enabled)<svg class="mascot"><use href="#couple"/></svg>@endif
            <div class="icon-badge">
                <svg viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z"/></svg>
            </div>
            <h2 class="title">Manual do bom convidado</h2>
            <p class="script-sub">Informações úteis</p>

            @if($hasDressCode)
                <div class="card" style="max-width:440px;margin:0 auto;">
                    <p class="section-title">Traje</p>
                    <p class="place">{{ $invitation->dress_code ?: 'Como se vestir' }}</p>
                    @if($invitation->dress_code_notes)
                        <p class="note" style="margin-top:10px;">{{ $invitation->dress_code_notes }}</p>
                    @endif
                </div>
            @endif

            @if(count($tips) > 0)
                <div class="tips-grid">
                    @foreach($tips as $tip)
                        <div class="tip-card">
                            <div class="icon-badge">@include('invitations._tip-icon', ['icon' => $tip['icon'] ?? 'sparkle'])</div>
                            <p>{{ $tip['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            @endif

            @if($next = $nextAfter('manual'))
                <a href="#{{ $next }}" class="next-btn" aria-label="Ver a secção seguinte"><svg viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg></a>
            @endif
        </div>
    </section>
    @endif

    {{-- ── Gallery ─────────────────────────────────────────────────── --}}
    @if($hasGallery)
    <section class="panel" id="galeria">
        <div class="panel-inner dir-right">
            <div class="icon-badge">
                <svg viewBox="0 0 24 24"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2Z"/><circle cx="12" cy="13" r="4"/></svg>
            </div>
            <h2 class="title">Galeria</h2>
            <p class="script-sub">Nossos momentos</p>
            <div class="gallery">
                @foreach($invitation->photos as $photo)
                    <figure>
                        <img src="{{ $photo->image_url }}" alt="{{ $photo->caption ?: $invitation->coupleNames() }}"
                             loading="lazy" onclick="openLightbox(this.src)">
                        @if($photo->caption)<figcaption>{{ $photo->caption }}</figcaption>@endif
                    </figure>
                @endforeach
            </div>
            @if($next = $nextAfter('galeria'))
                <a href="#{{ $next }}" class="next-btn" aria-label="Ver a secção seguinte"><svg viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg></a>
            @endif
        </div>
    </section>
    <div class="lightbox" id="lightbox" onclick="closeLightbox()">
        <button class="lightbox-close" type="button" aria-label="Fechar">&times;</button>
        <img id="lightbox-img" src="" alt="">
    </div>
    @endif

    {{-- ── Gifts ───────────────────────────────────────────────────── --}}
    @if($hasGifts)
    <section class="panel" id="presentes">
        <div class="panel-inner dir-scale">
            <div class="icon-badge">
                <svg viewBox="0 0 24 24"><rect x="3" y="8" width="18" height="13" rx="2"/><path d="M12 8v13M3 12h18M7.5 8a2.5 2.5 0 1 1 0-5C10 3 12 8 12 8s2-5 4.5-5a2.5 2.5 0 1 1 0 5"/></svg>
            </div>
            <h2 class="title">Lista de presentes</h2>
            <p class="script-sub">Se quiser nos mimar</p>
            @if($invitation->gift_message)
                <p class="quote" style="font-size:1.05rem;">{{ $invitation->gift_message }}</p>
            @endif

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
                            <p style="font-size:.9rem;color:var(--muted);margin-bottom:12px;">Em nome de {{ $invitation->pix_name }}</p>
                        @endif
                        <button type="button" class="btn" onclick="copyPix(this)"><span>Copiar chave</span></button>
                    </div>
                </div>
            @endif

            @if($invitation->bank_details)
                <div class="card">
                    <p class="section-title">Dados bancários</p>
                    <p style="white-space:pre-line;margin-top:8px;">{{ $invitation->bank_details }}</p>
                </div>
            @endif

            @if($invitation->gifts->isNotEmpty())
                <div class="gift-grid" style="margin-top:14px;">
                    @foreach($invitation->gifts as $gift)
                        <div class="gift">
                            @if($gift->image_url)<img src="{{ $gift->image_url }}" alt="{{ $gift->name }}" loading="lazy">@endif
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

            @if($next = $nextAfter('presentes'))
                <a href="#{{ $next }}" class="next-btn" aria-label="Ver a secção seguinte"><svg viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg></a>
            @endif
        </div>
    </section>
    @endif

    {{-- ── RSVP ────────────────────────────────────────────────────── --}}
    @if($showRsvp)
    <section class="panel" id="rsvp">
        <div class="blob" data-speed=".1" style="width:220px;height:220px;bottom:-50px;left:-70px;background:radial-gradient(circle,var(--gold-light),transparent 70%);"></div>
        <div class="panel-inner dir-scale">
            @if($invitation->mascot_enabled)<svg class="mascot"><use href="#couple"/></svg>@endif
            <div class="rsvp-panel">
                <p class="script-sub" style="margin-bottom:0;">RSVP</p>
                <h2 class="title">Confirme a sua presença</h2>
                @if($invitation->rsvp_deadline)
                    <p class="rsvp-note">
                        Confirme até {{ $invitation->rsvp_deadline->day }} de {{ $months[(int) $invitation->rsvp_deadline->month] }}
                    </p>
                @endif

                @if(session('rsvp_done') === 'yes')
                    <div class="alert alert-ok" style="margin-top:18px;">Presença confirmada! Obrigado — estamos muito felizes por celebrar com você. &#128141;</div>
                @elseif(session('rsvp_done') === 'no')
                    <div class="alert alert-info" style="margin-top:18px;">Resposta registada. Vamos sentir a sua falta, mas obrigado por nos avisar.</div>
                @endif
                @error('rsvp')<div class="alert alert-bad" style="margin-top:18px;">{{ $message }}</div>@enderror

                @if($invitation->rsvpOpen())
                    <form method="POST" action="{{ route('invitation.rsvp', $invitation->slug) }}" id="rsvpForm" style="margin-top:24px;">
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
                                <label class="choice">
                                    <input type="radio" name="attending" value="1" checked onchange="toggleAttending(true)">
                                    <span>&#10003; Sim, estarei lá</span>
                                </label>
                                <label class="choice">
                                    <input type="radio" name="attending" value="0" onchange="toggleAttending(false)">
                                    <span>Não poderei ir</span>
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

                        @if($invitation->song_request_enabled)
                            <div class="field">
                                <label class="fl" for="rsvp-song">&#127925; Música que te faz dançar (para o DJ)</label>
                                <input id="rsvp-song" type="text" name="song_request" maxlength="160"
                                       value="{{ old('song_request') }}" placeholder="Ex: Artista — Nome da música">
                            </div>
                        @endif

                        <div class="field">
                            <label class="fl" for="rsvp-msg">Recado para o casal (opcional)</label>
                            <textarea id="rsvp-msg" name="message" rows="3" maxlength="800">{{ old('message') }}</textarea>
                        </div>

                        @if($invitation->rsvpOnSite())
                            <button type="submit" class="btn btn-wide shimmer">Enviar resposta</button>
                        @endif
                        @if($invitation->rsvpOnWhatsapp())
                            <button type="button" class="btn btn-wide btn-ghost" style="margin-top:10px;"
                                    onclick="sendRsvpWhatsapp()">
                                <svg viewBox="0 0 24 24" fill="currentColor" stroke="none"><path d="M17.6 6.3A8.7 8.7 0 0 0 3.8 16.5L3 21l4.6-.8a8.7 8.7 0 0 0 12.6-7.8 8.6 8.6 0 0 0-2.6-6.1Zm-5.6 13a7.2 7.2 0 0 1-3.7-1l-.3-.2-2.7.5.5-2.6-.2-.3a7.3 7.3 0 1 1 6.4 3.6Z"/></svg>
                                Confirmar via WhatsApp
                            </button>
                        @endif
                    </form>
                @else
                    <div class="alert alert-info" style="margin-top:18px;">
                        As confirmações de presença estão encerradas. Em caso de dúvida, fale diretamente com o casal.
                    </div>
                @endif
            </div>

            @if($invitation->contact_whatsapp || $invitation->contact_phone || $invitation->contact_email)
                <p style="font-size:.95rem;color:var(--muted);">
                    Dúvidas?
                    @if($invitation->contact_whatsapp)
                        <a href="https://wa.me/{{ $invitation->whatsappNumber() }}" target="_blank" rel="noopener" style="color:var(--primary);">WhatsApp</a>
                    @endif
                    @if($invitation->contact_phone)
                        &middot; <a href="tel:{{ $invitation->contact_phone }}" style="color:var(--primary);">{{ $invitation->contact_phone }}</a>
                    @endif
                    @if($invitation->contact_email)
                        &middot; <a href="mailto:{{ $invitation->contact_email }}" style="color:var(--primary);">{{ $invitation->contact_email }}</a>
                    @endif
                </p>
            @endif

            @if($next = $nextAfter('rsvp'))
                <a href="#{{ $next }}" class="next-btn" aria-label="Ver a secção seguinte"><svg viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg></a>
            @endif
        </div>
    </section>
    @endif

    {{-- ── Guestbook ───────────────────────────────────────────────── --}}
    @if($showGuestbook)
    <section class="panel" id="recados">
        <div class="panel-inner dir-left">
            <div class="icon-badge">
                <svg viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2Z"/></svg>
            </div>
            <h2 class="title">Recados dos convidados</h2>
            <p class="script-sub">Mural de carinho</p>

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
                <div>
                    @foreach($invitation->messages as $noteItem)
                        <div class="note">
                            <p class="note-name">{{ $noteItem->name }}
                                <span class="note-when">&middot; {{ $noteItem->created_at->format('d/m/Y') }}</span>
                            </p>
                            <p class="note-text">{{ $noteItem->message }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </section>
    @endif

    {{-- ── Printable keepsake card ─────────────────────────────────── --}}
    <section class="panel" id="convite" style="padding-top:20px;">
        <div class="panel-inner dir-scale" style="width:min(94vw,520px);">
            <span class="badge-tag no-print">Lembrança</span>
            <h2 class="title no-print">O seu convite</h2>
            <p class="script-sub no-print">Guarde ou imprima</p>

            <div class="keepsake" id="keepsake">
                <div class="keepsake-text">
                    <p class="ks-tag">{{ $isWedding ? 'Casamento' : 'Festa de Noivado' }}</p>
                    <div>
                        <span class="ks-name">{{ $invitation->partner_one_name }}</span>
                        @if($invitation->partner_two_name)
                            <span class="ks-and">e</span>
                            <span class="ks-name">{{ $invitation->partner_two_name }}</span>
                        @endif
                    </div>
                    <div style="width:100%;">
                        <p class="ks-month">{{ $months[(int) $starts->month] }}</p>
                        <div class="ks-date-row">
                            <span class="ks-line"></span>
                            <span class="ks-side-txt">{{ $weekdays[(int) $starts->format('w')] }}</span>
                            <span class="ks-day">{{ $starts->day }}</span>
                            @if($shortTime)<span class="ks-side-txt">às {{ $shortTime }}</span>@endif
                            <span class="ks-line"></span>
                        </div>
                        <p class="ks-year">{{ $starts->year }}</p>
                    </div>
                    <p class="ks-body">Têm a honra de convidar para celebrar o seu {{ $eventWord }}</p>
                    <div>
                        <p class="ks-guest-label">Convidado(a) de honra</p>
                        <p class="ks-guest">{{ $guestLabel }}</p>
                    </div>
                    @if($fullAddress)
                        <p class="ks-loc">{{ $fullAddress }}</p>
                    @endif
                    <p class="ks-foot">Divirta-se!</p>
                </div>
                <div class="keepsake-side" @if($invitation->cover_url) style="background-image:url('{{ $invitation->cover_url }}')" @endif></div>
            </div>

            <div class="btn-row no-print" style="margin-top:20px;">
                <button type="button" class="btn btn-gold shimmer" onclick="window.print()">
                    <svg viewBox="0 0 24 24"><path d="M6 9V2h12v7M6 18H4a2 2 0 0 1-2-2v-5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v5a2 2 0 0 1-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                    Baixar / imprimir convite
                </button>
            </div>
        </div>
    </section>

    {{-- ── Footer ──────────────────────────────────────────────────── --}}
    <footer class="footer">
        <p class="footer-names">{{ $invitation->coupleNames() }}</p>
        <p class="footer-hash">
            {{ mb_strtoupper($longDate) }} DE {{ $starts->year }}
            @if($invitation->hashtag)
                &middot; {{ Str::startsWith($invitation->hashtag, '#') ? $invitation->hashtag : '#' . $invitation->hashtag }}
            @endif
        </p>
        <div class="share">
            <a href="https://wa.me/?text={{ urlencode($invitation->coupleNames() . ' — ' . $invitation->publicUrl()) }}"
               target="_blank" rel="noopener" title="Partilhar no WhatsApp" aria-label="Partilhar no WhatsApp">&#128172;</a>
            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($invitation->publicUrl()) }}"
               target="_blank" rel="noopener" title="Partilhar no Facebook" aria-label="Partilhar no Facebook">f</a>
            <button type="button" onclick="copyLink(this)" title="Copiar link" aria-label="Copiar link">&#128279;</button>
        </div>
        <p class="credit">Convite criado com <a href="{{ route('invitation.landing.pt') }}">{{ config('qrgenerate.name') }}</a></p>
    </footer>
</div>

<div id="toast"><span id="toastMsg"></span></div>
<canvas id="confetti"></canvas>
<script>
var INVITE_URL  = @json($invitation->publicUrl());
var FULL_ADDR   = @json($fullAddress);
var WA_NUMBER   = @json($invitation->rsvpOnWhatsapp() ? $invitation->whatsappNumber() : null);
var WA_HEADING  = @json(($isWedding ? '💍 Confirmação de casamento' : '💍 Confirmação de noivado') . ' — ' . $invitation->coupleNames());
var HAS_ENVELOPE = @json((bool) $invitation->envelope_enabled);

// ── Toast ──────────────────────────────────────────────────────────
function showToast(msg) {
    var el = document.getElementById('toast');
    document.getElementById('toastMsg').textContent = msg;
    el.classList.add('show');
    clearTimeout(showToast._t);
    showToast._t = setTimeout(function () { el.classList.remove('show'); }, 2800);
}

// ── Envelope intro ─────────────────────────────────────────────────
(function () {
    if (!HAS_ENVELOPE) return;

    var screen = document.getElementById('envelope-screen');
    var env = document.getElementById('envelope');
    var opened = false;

    function open() {
        if (opened) return;
        opened = true;
        env.classList.add('open');
        startMusic();
        setTimeout(function () {
            screen.classList.add('hidden');
            document.getElementById('stage').classList.add('show');
            // Reveal whatever is already in view now that the stage is visible.
            window.dispatchEvent(new Event('scroll'));
        }, 950);
    }

    env.addEventListener('click', open);
    document.getElementById('envSeal').addEventListener('click', open);
    document.getElementById('envHint').addEventListener('click', open);
    // A guest who lands on a deep link should not be trapped behind the envelope.
    if (window.location.hash && window.location.hash !== '#inicio') open();
})();

// ── Countdown ──────────────────────────────────────────────────────
(function () {
    var el = document.getElementById('cd');
    if (!el) return;

    // Parsed without a timezone so it counts down on the visitor's own clock.
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

// ── Stagger reveal ─────────────────────────────────────────────────
(function () {
    var panels = document.querySelectorAll('.panel-inner');
    if (!('IntersectionObserver' in window)) {
        panels.forEach(function (p) { p.classList.add('reveal'); });
        return;
    }
    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) { e.target.classList.toggle('reveal', e.isIntersecting); });
    }, { threshold: 0.18, rootMargin: '0px 0px -8% 0px' });
    panels.forEach(function (p) { io.observe(p); });
})();

// ── Nav dots ───────────────────────────────────────────────────────
(function () {
    var dots = document.querySelectorAll('.navdots a');
    if (!dots.length || !('IntersectionObserver' in window)) return;

    var io = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (!e.isIntersecting) return;
            dots.forEach(function (d) { d.classList.remove('active'); });
            var match = document.querySelector('.navdots a[data-target="' + e.target.id + '"]');
            if (match) match.classList.add('active');
        });
    }, { threshold: 0.5 });

    document.querySelectorAll('section.panel[id]').forEach(function (s) { io.observe(s); });
})();

// ── Parallax blobs ─────────────────────────────────────────────────
(function () {
    var blobs = Array.prototype.slice.call(document.querySelectorAll('.blob'));
    if (!blobs.length) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    var ticking = false;
    function paint() {
        var mid = window.innerHeight / 2;
        blobs.forEach(function (b) {
            var speed = parseFloat(b.dataset.speed) || 0.1;
            var top = b.parentElement.getBoundingClientRect().top;
            b.style.transform = 'translateY(' + ((top - mid) * speed) + 'px)';
        });
        ticking = false;
    }
    window.addEventListener('scroll', function () {
        if (!ticking) { requestAnimationFrame(paint); ticking = true; }
    }, { passive: true });
    paint();
})();

// ── Falling petals ─────────────────────────────────────────────────
(function () {
    var canvas = document.getElementById('petals');
    if (!canvas) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    var ctx = canvas.getContext('2d');
    var w, h, petals = [];
    var styles = getComputedStyle(document.documentElement);
    var colors = [
        styles.getPropertyValue('--primary').trim() || '#b08968',
        styles.getPropertyValue('--gold-light').trim() || '#e2c78a'
    ];

    function resize() { w = canvas.width = window.innerWidth; h = canvas.height = window.innerHeight; }
    window.addEventListener('resize', resize);
    resize();

    function Petal(initial) { this.reset(initial); }
    Petal.prototype.reset = function (initial) {
        this.x = Math.random() * w;
        this.y = initial ? Math.random() * h : -10;
        this.size = Math.random() * 4 + 3;
        this.vy = Math.random() * 0.5 + 0.25;
        this.vx = Math.sin(Math.random() * Math.PI) * 0.4;
        this.alpha = Math.random() * 0.3 + 0.12;
        this.color = colors[Math.random() > 0.5 ? 0 : 1];
        this.rot = Math.random() * 360;
        this.spin = (Math.random() - 0.5) * 1.2;
    };

    var count = window.innerWidth < 640 ? 10 : 16;
    for (var i = 0; i < count; i++) petals.push(new Petal(true));

    (function loop() {
        ctx.clearRect(0, 0, w, h);
        petals.forEach(function (p) {
            p.y += p.vy; p.x += p.vx; p.rot += p.spin;
            if (p.y > h + 10) p.reset(false);
            ctx.save();
            ctx.translate(p.x, p.y);
            ctx.rotate(p.rot * Math.PI / 180);
            ctx.globalAlpha = p.alpha;
            ctx.fillStyle = p.color;
            ctx.beginPath();
            ctx.ellipse(0, 0, p.size, p.size * 1.8, 0, 0, Math.PI * 2);
            ctx.fill();
            ctx.restore();
        });
        requestAnimationFrame(loop);
    })();
})();

// ── Confetti ───────────────────────────────────────────────────────
function burstConfetti() {
    var canvas = document.getElementById('confetti');
    var ctx = canvas.getContext('2d');
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;

    var styles = getComputedStyle(document.documentElement);
    var colors = [
        styles.getPropertyValue('--primary').trim(),
        styles.getPropertyValue('--accent').trim(),
        styles.getPropertyValue('--gold').trim(),
        styles.getPropertyValue('--gold-light').trim(),
        '#fff0d0'
    ];

    var pieces = [];
    for (var i = 0; i < 120; i++) {
        pieces.push({
            x: canvas.width / 2 + (Math.random() - 0.5) * 60,
            y: canvas.height / 2 + 100,
            vx: (Math.random() - 0.5) * 14,
            vy: -Math.random() * 14 - 6,
            size: Math.random() * 8 + 4,
            color: colors[Math.floor(Math.random() * colors.length)],
            rot: Math.random() * 360,
            spin: (Math.random() - 0.5) * 12
        });
    }

    var start = null;
    function frame(ts) {
        if (!start) start = ts;
        var progress = (ts - start) / 1000;
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        pieces.forEach(function (p) {
            p.x += p.vx; p.y += p.vy; p.vy += 0.38; p.rot += p.spin;
            ctx.save();
            ctx.translate(p.x, p.y);
            ctx.rotate(p.rot * Math.PI / 180);
            ctx.globalAlpha = Math.max(0, 1 - progress / 2.8);
            ctx.fillStyle = p.color;
            ctx.fillRect(-p.size / 2, -p.size / 2, p.size, p.size * 0.7);
            ctx.restore();
        });
        if (progress < 3) requestAnimationFrame(frame);
        else ctx.clearRect(0, 0, canvas.width, canvas.height);
    }
    requestAnimationFrame(frame);
}

// Celebrate a reply that just went through.
@if(session('rsvp_done') === 'yes')
    window.addEventListener('load', function () { setTimeout(burstConfetti, 400); });
@endif

// ── RSVP form behaviour ────────────────────────────────────────────
function toggleAttending(yes) {
    var fields = document.getElementById('companion-fields');
    if (fields) fields.style.display = yes ? '' : 'none';
    var song = document.getElementById('rsvp-song');
    if (song) song.closest('.field').style.display = yes ? '' : 'none';
}

function toggleCompanionNames(value) {
    var field = document.getElementById('companion-names-field');
    if (field) field.style.display = Number(value) > 0 ? '' : 'none';
}

function sendRsvpWhatsapp() {
    var form = document.getElementById('rsvpForm');
    if (!form || !WA_NUMBER) return;

    var name = form.querySelector('[name=name]').value.trim();
    if (!name) {
        showToast('Escreva o seu nome primeiro.');
        form.querySelector('[name=name]').focus();
        return;
    }

    var attending = form.querySelector('[name=attending]:checked').value === '1';
    var get = function (sel) { var el = form.querySelector(sel); return el ? el.value.trim() : ''; };

    var lines = [WA_HEADING, '', '👤 Nome: ' + name, '✨ Presença: ' + (attending ? 'Sim' : 'Não')];
    if (attending) {
        var companions = get('[name=companions]');
        if (companions && Number(companions) > 0) {
            lines.push('👥 Acompanhantes: ' + companions);
            var names = get('[name=companion_names]');
            if (names) lines.push('   (' + names + ')');
        }
    }
    var song = get('[name=song_request]');
    if (song && attending) lines.push('🎵 Música para o DJ: ' + song);
    var message = get('[name=message]');
    if (message) lines.push('💌 Recado: ' + message);

    burstConfetti();
    showToast('A abrir o WhatsApp…');
    setTimeout(function () {
        window.open('https://wa.me/' + WA_NUMBER + '?text=' + encodeURIComponent(lines.join('\n')), '_blank');
    }, 600);
}

// ── Gallery lightbox ───────────────────────────────────────────────
function openLightbox(src) {
    var box = document.getElementById('lightbox');
    if (!box) return;
    document.getElementById('lightbox-img').src = src;
    box.classList.add('open');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    var box = document.getElementById('lightbox');
    if (!box) return;
    box.classList.remove('open');
    document.body.style.overflow = '';
}

document.addEventListener('keydown', function (e) {
    if (e.key !== 'Escape') return;
    var box = document.getElementById('lightbox');
    if (box && box.classList.contains('open')) closeLightbox();
});

// ── Copy helpers ───────────────────────────────────────────────────
function copyText(text, button, okLabel, toastMsg) {
    var target = button ? (button.querySelector('span') || button) : null;
    var restore = target ? target.innerHTML : null;

    var done = function () {
        if (target) {
            target.innerHTML = okLabel;
            setTimeout(function () { target.innerHTML = restore; }, 2200);
        }
        if (toastMsg) showToast(toastMsg);
    };

    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(done);
        return;
    }

    var ta = document.createElement('textarea');
    ta.value = text;
    ta.style.position = 'fixed';
    ta.style.opacity = '0';
    document.body.appendChild(ta);
    ta.select();
    try { document.execCommand('copy'); done(); } catch (e) { /* ignore */ }
    document.body.removeChild(ta);
}

function copyAddress(button) { copyText(FULL_ADDR, button, 'Copiado!', 'Endereço copiado'); }
function copyPix(button) {
    var key = document.getElementById('pixKey');
    if (key) copyText(key.textContent.trim(), button, 'Copiado!', 'Chave copiada');
}
function copyLink(button) { copyText(INVITE_URL, button, '&#10003;', 'Link copiado'); }

// ── Background music ───────────────────────────────────────────────
var musicPlaying = false;

function updateMusicButton() {
    var btn = document.getElementById('musicBtn');
    if (!btn) return;
    btn.classList.toggle('playing', musicPlaying);
    btn.title = musicPlaying ? 'Pausar a música' : 'Tocar a música';
}

function startMusic() {
    var audio = document.getElementById('bgm');
    if (!audio) return;
    audio.volume = 0.5;
    audio.play().then(function () {
        musicPlaying = true;
        updateMusicButton();
    }).catch(function () { /* the browser blocked autoplay; the button still works */ });
}

function stopMusic() {
    var audio = document.getElementById('bgm');
    if (!audio) return;
    audio.pause();
    musicPlaying = false;
    updateMusicButton();
}

(function () {
    var btn = document.getElementById('musicBtn');
    if (!btn) return;
    btn.addEventListener('click', function () { musicPlaying ? stopMusic() : startMusic(); });
})();

// ── Welcome the named guest ────────────────────────────────────────
@if($guestName)
    window.addEventListener('load', function () {
        setTimeout(function () { showToast('Bem-vindo(a), ' + @json($guestName) + '!'); }, HAS_ENVELOPE ? 2200 : 1200);
    });
@endif
</script>
</body>
</html>
