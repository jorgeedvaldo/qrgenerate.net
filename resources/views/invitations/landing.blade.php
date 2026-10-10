@extends('layouts.app')

@php
$lang = $pageLocale ?? 'pt';
$isPt = ($lang === 'pt');
$createUrl = auth()->check() ? route('invitations.create') : ($isPt ? route('register.pt') : route('register'));

$faqs = $isPt ? [
    ['q' => 'O convite online é realmente grátis?',
     'a' => 'Sim. Criar a conta e montar o convite de casamento ou noivado é grátis. Você recebe um link exclusivo e um QR Code sem pagar nada.'],
    ['q' => 'Como funciona o link personalizado com o nome do convidado?',
     'a' => 'Cada convidado pode receber um link que o saúda pelo nome. Basta acrescentar <code>?c=Nome</code> ao link do convite — por exemplo <code>/convite/aurora-e-edvaldo?c=Família%20Silva</code> — ou cadastrar a lista de convidados e copiar o link gerado para cada um.'],
    ['q' => 'Os convidados precisam criar conta para confirmar presença?',
     'a' => 'Não. Eles abrem o link, preenchem o nome e confirmam em segundos. Você vê todas as respostas no seu painel e pode exportar em CSV.'],
    ['q' => 'Posso editar o convite depois de enviar?',
     'a' => 'Sim. Entre na sua conta, abra o convite e altere o que quiser. As mudanças aparecem imediatamente para quem abrir o link — o endereço não muda.'],
    ['q' => 'Dá para colocar o mapa do local da cerimónia?',
     'a' => 'Sim. Basta escrever o endereço e geramos o botão "Ver no mapa" automaticamente. Também criamos um botão para o convidado adicionar o evento à agenda do telefone.'],
    ['q' => 'Posso usar para noivado, casamento civil e religioso no mesmo convite?',
     'a' => 'Sim. Adicione quantos momentos quiser — cerimónia, recepção, festa — cada um com o seu horário, local e observações.'],
    ['q' => 'Como funciona a lista de presentes?',
     'a' => 'Você adiciona os presentes e, se quiser, a chave Pix ou os dados bancários. O convidado pode reservar um presente com o seu nome, para que duas pessoas não levem a mesma coisa.'],
    ['q' => 'Posso entrar com a minha conta Google?',
     'a' => 'Sim. Pode criar a conta com o Google num clique ou usar apenas o e-mail e uma senha.'],
] : [
    ['q' => 'Is the online invitation really free?',
     'a' => 'Yes. Creating an account and building your wedding or engagement invitation is free. You get your own link and a QR code at no cost.'],
    ['q' => 'How does the personalised guest link work?',
     'a' => 'Each guest can get a link that greets them by name. Append <code>?c=Name</code> to the invitation link — for example <code>/convite/aurora-and-edvaldo?c=The%20Smiths</code> — or add your guest list and copy the link generated for each one.'],
    ['q' => 'Do guests need an account to reply?',
     'a' => 'No. They open the link, type their name and reply in seconds. You see every reply in your dashboard and can export it as CSV.'],
    ['q' => 'Can I edit the invitation after sending it?',
     'a' => 'Yes. Sign in, open the invitation and change anything. Updates appear immediately for anyone opening the link — the address never changes.'],
    ['q' => 'Can I add a map of the venue?',
     'a' => 'Yes. Just type the address and we build the "View on map" button automatically. We also add a button so guests can save the event to their phone calendar.'],
    ['q' => 'Can one invitation cover the engagement and both ceremonies?',
     'a' => 'Yes. Add as many moments as you like — ceremony, reception, party — each with its own time, venue and notes.'],
    ['q' => 'How does the gift list work?',
     'a' => 'You add the gifts and, if you want, your transfer details. A guest can reserve a gift under their name so two people do not bring the same thing.'],
    ['q' => 'Can I sign in with Google?',
     'a' => 'Yes. Create your account with Google in one click, or use just an email and a password.'],
];
@endphp

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebApplication",
  "name": "{{ $isPt ? 'Convite de Casamento e Noivado Online – QRGenerate' : 'Wedding & Engagement Invitation Generator – QRGenerate' }}",
  "url": "{{ $isPt ? route('invitation.landing.pt') : route('invitation.landing.en') }}",
  "applicationCategory": "LifestyleApplication",
  "operatingSystem": "Web",
  "offers": { "@@type": "Offer", "price": "0", "priceCurrency": "EUR" },
  "featureList": [
    {{ $isPt
      ? '"Convite virtual de casamento e noivado","Link personalizado por convidado","Confirmação de presença (RSVP) online","Contagem regressiva","Lista de presentes e Pix","Galeria de fotos","Mural de recados","QR Code do convite"'
      : '"Online wedding and engagement invitation","Personalised link per guest","Online RSVP","Countdown","Gift list and transfer details","Photo gallery","Guestbook","Invitation QR code"'
    }}
  ],
  "description": "{{ $isPt ? 'Crie o convite virtual do seu casamento ou noivado em minutos, com RSVP, contagem regressiva, mapa, lista de presentes e QR Code.' : 'Create your online wedding or engagement invitation in minutes, with RSVP, countdown, map, gift list and QR code.' }}"
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "HowTo",
  "name": "{{ $isPt ? 'Como criar um convite de casamento online' : 'How to create an online wedding invitation' }}",
  "step": [
    { "@@type": "HowToStep", "position": 1, "name": "{{ $isPt ? 'Crie a sua conta' : 'Create your account' }}" },
    { "@@type": "HowToStep", "position": 2, "name": "{{ $isPt ? 'Preencha os dados do convite' : 'Fill in the invitation details' }}" },
    { "@@type": "HowToStep", "position": 3, "name": "{{ $isPt ? 'Partilhe o link ou o QR Code' : 'Share the link or the QR code' }}" }
  ]
}
</script>
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'FAQPage',
    'mainEntity' => array_map(fn ($faq) => [
        '@type' => 'Question',
        'name' => $faq['q'],
        'acceptedAnswer' => ['@type' => 'Answer', 'text' => strip_tags($faq['a'])],
    ], $faqs),
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@push('styles')
<style>
    .landing-wrap { max-width: 960px; margin: 0 auto; padding: 0 16px 80px; }
    .landing-hero { text-align: center; padding: 48px 20px 40px; }
    .landing-hero h1 { font-size: 36px; font-weight: 800; color: #1a1a1a; margin: 0 0 16px; line-height: 1.2; }
    .landing-hero h1 span { color: #7b4397; }
    .landing-hero p { font-size: 18px; color: #555; max-width: 640px; margin: 0 auto 28px; line-height: 1.6; }
    .hero-badges { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; margin-bottom: 32px; }
    .hero-badge { background: #f3edf7; color: #5b287a; border-radius: 99px; padding: 6px 16px; font-size: 13px; font-weight: 600; }
    .cta-btn { display: inline-block; background: linear-gradient(135deg, #7b4397, #5b287a); color: #fff !important; text-decoration: none; border-radius: 12px; padding: 16px 40px; font-size: 18px; font-weight: 700; transition: opacity .2s; box-shadow: 0 4px 16px rgba(123,67,151,.35); }
    .cta-btn:hover { opacity: .9; text-decoration: none; }
    .cta-sub { font-size: 13px; color: #999; margin-top: 10px; }
    .section-title { font-size: 26px; font-weight: 800; color: #1a1a1a; text-align: center; margin: 0 0 8px; }
    .section-sub { text-align: center; color: #777; font-size: 15px; margin-bottom: 32px; }
    .steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 60px; }
    .step-card { background: #fff; border-radius: 14px; padding: 28px 22px; text-align: center; box-shadow: 0 2px 12px rgba(0,0,0,.07); border-top: 4px solid #7b4397; }
    .step-number { width: 40px; height: 40px; background: linear-gradient(135deg, #7b4397, #5b287a); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 800; margin: 0 auto 14px; }
    .step-card h3 { font-size: 16px; font-weight: 700; color: #1a1a1a; margin: 0 0 8px; }
    .step-card p { font-size: 14px; color: #666; line-height: 1.6; margin: 0; }
    .features-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 60px; }
    .feature-item { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,.06); display: flex; gap: 14px; align-items: flex-start; }
    .feature-icon { font-size: 28px; flex-shrink: 0; }
    .feature-text h4 { font-size: 15px; font-weight: 700; color: #1a1a1a; margin: 0 0 4px; }
    .feature-text p { font-size: 13px; color: #666; line-height: 1.5; margin: 0; }
    .faq-list { margin-bottom: 60px; }
    .faq-item { background: #fff; border-radius: 12px; margin-bottom: 10px; box-shadow: 0 1px 6px rgba(0,0,0,.06); overflow: hidden; }
    .faq-q { padding: 16px 20px; font-weight: 700; font-size: 15px; color: #1a1a1a; cursor: pointer; display: flex; justify-content: space-between; align-items: center; gap: 12px; }
    .faq-q::after { content: '+'; font-size: 22px; color: #7b4397; font-weight: 400; transition: transform .2s; flex: 0 0 auto; }
    .faq-item.open .faq-q::after { transform: rotate(45deg); }
    .faq-a { display: none; padding: 0 20px 16px; font-size: 14px; color: #555; line-height: 1.7; border-top: 1px solid #f3f4f6; padding-top: 14px; }
    .faq-item.open .faq-a { display: block; }
    .faq-a code { font-size: 13px; background: #f3edf7; color: #5b287a; padding: 2px 6px; border-radius: 4px; }
    .cta-section { background: linear-gradient(135deg, #7b4397, #5b287a); border-radius: 16px; padding: 40px; text-align: center; color: #fff; }
    .cta-section h2 { font-size: 28px; font-weight: 800; margin: 0 0 10px; }
    .cta-section p { font-size: 15px; opacity: .85; margin: 0 0 24px; }
    .cta-btn-white { display: inline-block; background: #fff; color: #5b287a !important; text-decoration: none; border-radius: 10px; padding: 14px 36px; font-size: 16px; font-weight: 700; transition: opacity .2s; }
    .cta-btn-white:hover { opacity: .9; text-decoration: none; }
    .lang-row { text-align: right; padding: 10px 0 0; }
    .lang-row a { font-size: 13px; color: #7b4397; border: 1px solid #d1bfe0; border-radius: 6px; padding: 4px 10px; text-decoration: none; }
    .lang-row a:hover { background: #f3edf7; }
    .type-cards { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 60px; }
    .type-card { background: #fff; border-radius: 14px; padding: 26px; text-align: center; box-shadow: 0 2px 12px rgba(0,0,0,.07); }
    .type-card .emoji { font-size: 40px; display: block; margin-bottom: 12px; }
    .type-card h3 { font-size: 19px; font-weight: 700; margin: 0 0 8px; color: #1a1a1a; }
    .type-card p { font-size: 14px; color: #666; line-height: 1.6; margin: 0 0 18px; }
    .type-card a { display: inline-block; background: #f3edf7; color: #5b287a !important; border-radius: 8px; padding: 10px 24px; font-weight: 700; font-size: 14px; text-decoration: none; }
    .type-card a:hover { background: #ece0f3; text-decoration: none; }
    @media(max-width:680px) {
        .steps-grid, .features-grid, .type-cards { grid-template-columns: 1fr; }
        .landing-hero h1 { font-size: 26px; }
        .cta-section { padding: 30px 20px; }
    }
</style>
@endpush

@section('content')
<div class="landing-wrap">

    <div class="lang-row">
        @if($isPt)
            <a href="{{ route('invitation.landing.en') }}">🇬🇧 English</a>
        @else
            <a href="{{ route('invitation.landing.pt') }}">🇵🇹 Português</a>
        @endif
    </div>

    {{-- Hero --}}
    <div class="landing-hero">
        <div style="font-size:56px;margin-bottom:16px;">💍</div>
        <h1>
            @if($isPt)
                Crie o <span>Convite Virtual</span> do seu<br>Casamento ou Noivado
            @else
                Create Your <span>Online Invitation</span><br>for a Wedding or Engagement
            @endif
        </h1>
        <p>
            {{ $isPt
              ? 'Um convite bonito, com link personalizado para cada convidado, confirmação de presença, contagem regressiva, mapa, lista de presentes e QR Code. Pronto em minutos.'
              : 'A beautiful invitation with a personalised link for every guest, online RSVP, countdown, map, gift list and a QR code. Ready in minutes.' }}
        </p>
        <div class="hero-badges">
            @if($isPt)
                <span class="hero-badge">✅ Grátis</span>
                <span class="hero-badge">💌 Link por convidado</span>
                <span class="hero-badge">📝 Confirmação de presença</span>
                <span class="hero-badge">⏳ Contagem regressiva</span>
                <span class="hero-badge">🎁 Lista de presentes</span>
                <span class="hero-badge">📱 QR Code</span>
            @else
                <span class="hero-badge">✅ Free</span>
                <span class="hero-badge">💌 Link per guest</span>
                <span class="hero-badge">📝 Online RSVP</span>
                <span class="hero-badge">⏳ Countdown</span>
                <span class="hero-badge">🎁 Gift list</span>
                <span class="hero-badge">📱 QR code</span>
            @endif
        </div>
        <a href="{{ $createUrl }}" class="cta-btn">
            {{ $isPt ? '💐 Criar o meu convite' : '💐 Create my invitation' }}
        </a>
        <div class="cta-sub">
            {{ $isPt ? 'Conta grátis com Google ou e-mail · Sem cartão de crédito' : 'Free account with Google or email · No credit card' }}
        </div>
    </div>

    {{-- Two types --}}
    <h2 class="section-title">{{ $isPt ? 'Para que ocasião?' : 'What are you celebrating?' }}</h2>
    <p class="section-sub">{{ $isPt ? 'Escolha o tipo e nós adaptamos o convite' : 'Pick the type and we shape the invitation around it' }}</p>
    <div class="type-cards">
        <div class="type-card">
            <span class="emoji">💍</span>
            <h3>{{ $isPt ? 'Casamento' : 'Wedding' }}</h3>
            <p>{{ $isPt
                ? 'Cerimónia, recepção e festa num só convite, com traje, mapa, lista de presentes e confirmação de presença.'
                : 'Ceremony, reception and party in one invitation, with dress code, map, gift list and RSVP.' }}</p>
            <a href="{{ auth()->check() ? route('invitations.create', ['type' => 'wedding']) : $createUrl }}">
                {{ $isPt ? 'Criar convite de casamento' : 'Create a wedding invitation' }}
            </a>
        </div>
        <div class="type-card">
            <span class="emoji">💐</span>
            <h3>{{ $isPt ? 'Noivado' : 'Engagement' }}</h3>
            <p>{{ $isPt
                ? 'Anuncie o pedido, conte a sua história e convide a família com um link que saúda cada convidado pelo nome.'
                : 'Announce the proposal, tell your story and invite family with a link that greets each guest by name.' }}</p>
            <a href="{{ auth()->check() ? route('invitations.create', ['type' => 'engagement']) : $createUrl }}">
                {{ $isPt ? 'Criar convite de noivado' : 'Create an engagement invitation' }}
            </a>
        </div>
    </div>

    {{-- How it works --}}
    <h2 class="section-title">{{ $isPt ? 'Como funciona' : 'How it works' }}</h2>
    <p class="section-sub">{{ $isPt ? '3 passos para ter o seu convite online' : '3 steps to your online invitation' }}</p>
    <div class="steps-grid">
        <div class="step-card">
            <div class="step-number">1</div>
            <h3>{{ $isPt ? 'Crie a sua conta' : 'Create your account' }}</h3>
            <p>{{ $isPt
                ? 'Com o Google num clique ou apenas com o seu e-mail. A conta guarda os seus convites e as confirmações.'
                : 'With Google in one click, or just your email. Your account keeps your invitations and replies safe.' }}</p>
        </div>
        <div class="step-card">
            <div class="step-number">2</div>
            <h3>{{ $isPt ? 'Monte o convite' : 'Build the invitation' }}</h3>
            <p>{{ $isPt
                ? 'Nomes, data, fotos, história, local da cerimónia, traje, presentes e cores — tudo num formulário só.'
                : 'Names, date, photos, your story, the venue, dress code, gifts and colours — all in one form.' }}</p>
        </div>
        <div class="step-card">
            <div class="step-number">3</div>
            <h3>{{ $isPt ? 'Partilhe o link' : 'Share the link' }}</h3>
            <p>{{ $isPt
                ? 'Envie por WhatsApp, imprima o QR Code no convite em papel e acompanhe quem confirmou.'
                : 'Send it on WhatsApp, print the QR code on a paper invite and watch the replies come in.' }}</p>
        </div>
    </div>

    {{-- Features --}}
    <h2 class="section-title">{{ $isPt ? 'O que o convite inclui' : 'What the invitation includes' }}</h2>
    <p class="section-sub">{{ $isPt ? 'Tudo o que precisa, sem plugins nem mensalidade' : 'Everything you need, with no plugins and no monthly fee' }}</p>
    <div class="features-grid">
        @php
        $features = $isPt ? [
            ['💌', 'Link personalizado', 'Cada convidado vê o seu próprio nome no convite: basta usar ?c=Nome ou a lista de convidados.'],
            ['📝', 'Confirmação de presença', 'O convidado confirma, diz quantos acompanhantes leva e deixa um recado. Você exporta tudo em CSV.'],
            ['⏳', 'Contagem regressiva', 'Dias, horas e minutos para o grande dia, actualizados em tempo real.'],
            ['📍', 'Local e mapa', 'Cerimónia, recepção e festa com endereço, botão para o mapa e para adicionar à agenda.'],
            ['🎁', 'Lista de presentes', 'Presentes com foto e valor, chave Pix ou IBAN e reserva para não repetir presentes.'],
            ['📷', 'Galeria de fotos', 'Mostre as suas fotos preferidas numa galeria com visualização ampliada.'],
            ['💬', 'Mural de recados', 'Os convidados deixam mensagens de carinho directamente no convite.'],
            ['📱', 'QR Code e partilha', 'QR Code pronto a imprimir e botões de partilha para WhatsApp e Facebook.'],
        ] : [
            ['💌', 'Personalised link', 'Every guest sees their own name on the invitation — use ?c=Name or your guest list.'],
            ['📝', 'Online RSVP', 'Guests confirm, say how many companions they bring and leave a note. Export it all as CSV.'],
            ['⏳', 'Countdown', 'Days, hours and minutes to the big day, updating live.'],
            ['📍', 'Venue and map', 'Ceremony, reception and party with the address, a map button and a calendar button.'],
            ['🎁', 'Gift list', 'Gifts with photo and price, transfer details, and reservations so nothing is duplicated.'],
            ['📷', 'Photo gallery', 'Show your favourite photos in a gallery with full-size viewing.'],
            ['💬', 'Guestbook', 'Guests leave their wishes right on the invitation.'],
            ['📱', 'QR code and sharing', 'A print-ready QR code plus WhatsApp and Facebook share buttons.'],
        ];
        @endphp
        @foreach($features as [$icon, $heading, $text])
            <div class="feature-item">
                <div class="feature-icon">{{ $icon }}</div>
                <div class="feature-text">
                    <h4>{{ $heading }}</h4>
                    <p>{{ $text }}</p>
                </div>
            </div>
        @endforeach
    </div>

    {{-- FAQ --}}
    <h2 class="section-title">{{ $isPt ? 'Perguntas frequentes' : 'Frequently asked questions' }}</h2>
    <p class="section-sub">{{ $isPt ? 'As dúvidas mais comuns sobre o convite online' : 'The most common questions about the online invitation' }}</p>
    <div class="faq-list">
        @foreach($faqs as $i => $faq)
            <div class="faq-item {{ $i === 0 ? 'open' : '' }}">
                <div class="faq-q" onclick="this.parentNode.classList.toggle('open')">{{ $faq['q'] }}</div>
                <div class="faq-a">{!! $faq['a'] !!}</div>
            </div>
        @endforeach
    </div>

    {{-- Final CTA --}}
    <div class="cta-section">
        <h2>{{ $isPt ? 'Pronto para convidar?' : 'Ready to invite everyone?' }}</h2>
        <p>{{ $isPt
            ? 'Crie a conta grátis e monte o seu convite agora. Leva menos tempo do que escolher a fonte do convite em papel.'
            : 'Create your free account and build the invitation now. It takes less time than picking a font for the paper version.' }}</p>
        <a href="{{ $createUrl }}" class="cta-btn-white">
            {{ $isPt ? 'Começar agora' : 'Start now' }}
        </a>
    </div>

    {{-- Cross-link --}}
    <p style="text-align:center;margin-top:34px;font-size:14px;color:#777;">
        {{ $isPt ? 'Também oferecemos' : 'We also offer' }}
        <a href="{{ $isPt ? route('menu.landing.pt') : route('menu.landing.en') }}" style="color:#7b4397;font-weight:600;">
            {{ $isPt ? 'gerador de cardápio digital' : 'a digital menu generator' }}
        </a>
        {{ $isPt ? 'e' : 'and' }}
        <a href="{{ $isPt ? url('/pt') : url('/') }}" style="color:#7b4397;font-weight:600;">
            {{ $isPt ? 'gerador de QR Code grátis' : 'a free QR code generator' }}
        </a>.
    </p>
</div>
@endsection
