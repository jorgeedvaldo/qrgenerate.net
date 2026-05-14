@extends('layouts.app')

@php
$lang = $menuLocale ?? 'pt';
$isPt = ($lang === 'pt');
@endphp

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebApplication",
  "name": "{{ $isPt ? 'Gerador de Cardápio Digital – QRGenerate' : 'Digital Menu Generator – QRGenerate' }}",
  "url": "{{ $isPt ? route('menu.landing.pt') : route('menu.landing.en') }}",
  "applicationCategory": "BusinessApplication",
  "operatingSystem": "Web",
  "offers": { "@@type": "Offer", "price": "0", "priceCurrency": "BRL" },
  "featureList": [
    {{ $isPt
      ? '"Cardápio digital responsivo","QR Code gerado automaticamente","Link exclusivo de edição","Sem cadastro necessário","Etiquetas: vegano, vegetariano, sem glúten","Personalização de cores"'
      : '"Responsive digital menu","Automatic QR Code generation","Exclusive edit link","No signup required","Labels: vegan, vegetarian, gluten-free","Colour customisation"'
    }}
  ],
  "description": "{{ $isPt ? 'Crie um cardápio digital profissional para o seu restaurante em minutos. Grátis, sem cadastro e com QR Code.' : 'Create a professional digital menu for your restaurant in minutes. Free, no signup and with QR Code.' }}"
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "HowTo",
  "name": "{{ $isPt ? 'Como criar um cardápio digital com QR Code' : 'How to create a digital menu with QR Code' }}",
  "step": [
    {
      "@@type": "HowToStep",
      "position": "1",
      "name": "{{ $isPt ? 'Preencha as informações do restaurante' : 'Fill in restaurant information' }}",
      "text": "{{ $isPt ? 'Adicione o nome, descrição, endereço, telefone e redes sociais do seu restaurante.' : 'Add your restaurant name, description, address, phone and social media.' }}"
    },
    {
      "@@type": "HowToStep",
      "position": "2",
      "name": "{{ $isPt ? 'Adicione seções e itens ao cardápio' : 'Add sections and items to the menu' }}",
      "text": "{{ $isPt ? 'Crie seções como Entradas, Pratos Principais e Bebidas. Adicione itens com nome, preço e descrição.' : 'Create sections such as Starters, Mains and Drinks. Add items with name, price and description.' }}"
    },
    {
      "@@type": "HowToStep",
      "position": "3",
      "name": "{{ $isPt ? 'Receba o link e o QR Code' : 'Get your link and QR Code' }}",
      "text": "{{ $isPt ? 'Após salvar, você recebe um link público do cardápio e um QR Code para imprimir e compartilhar.' : 'After saving, you receive a public menu link and a QR Code to print and share.' }}"
    }
  ]
}
</script>
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "FAQPage",
  "mainEntity": [
    {
      "@@type": "Question",
      "name": "{{ $isPt ? 'É gratuito criar um cardápio digital?' : 'Is it free to create a digital menu?' }}",
      "acceptedAnswer": { "@@type": "Answer", "text": "{{ $isPt ? 'Sim, é totalmente gratuito. Não há planos pagos, não há limites de itens e não precisa de cartão de crédito.' : 'Yes, it is completely free. There are no paid plans, no item limits and no credit card required.' }}" }
    },
    {
      "@@type": "Question",
      "name": "{{ $isPt ? 'Preciso criar uma conta para usar?' : 'Do I need to create an account?' }}",
      "acceptedAnswer": { "@@type": "Answer", "text": "{{ $isPt ? 'Não. O cardápio é criado sem qualquer cadastro. Você recebe um link exclusivo para editar o cardápio quando precisar.' : 'No. The menu is created without any signup. You receive an exclusive link to edit the menu whenever you need.' }}" }
    },
    {
      "@@type": "Question",
      "name": "{{ $isPt ? 'Como edito o cardápio depois de criado?' : 'How do I edit the menu after creating it?' }}",
      "acceptedAnswer": { "@@type": "Answer", "text": "{{ $isPt ? 'Ao criar o cardápio, você recebe um link secreto de edição. Guarde esse link – qualquer pessoa que o tiver pode editar o cardápio.' : 'When creating the menu, you receive a secret edit link. Save this link – anyone who has it can edit the menu.' }}" }
    },
    {
      "@@type": "Question",
      "name": "{{ $isPt ? 'O QR Code é gerado automaticamente?' : 'Is the QR Code generated automatically?' }}",
      "acceptedAnswer": { "@@type": "Answer", "text": "{{ $isPt ? 'Sim. Após criar o cardápio, um QR Code é gerado automaticamente apontando para o link público do cardápio. Você pode baixar em PNG para imprimir.' : 'Yes. After creating the menu, a QR Code is automatically generated pointing to the public menu link. You can download it as PNG to print.' }}" }
    },
    {
      "@@type": "Question",
      "name": "{{ $isPt ? 'O cardápio funciona no celular?' : 'Does the menu work on mobile?' }}",
      "acceptedAnswer": { "@@type": "Answer", "text": "{{ $isPt ? 'Sim. O cardápio público é totalmente responsivo e otimizado para smartphones, que é o dispositivo mais usado por clientes para escanear QR Codes.' : 'Yes. The public menu is fully responsive and optimised for smartphones, which is the most common device customers use to scan QR Codes.' }}" }
    }
  ]
}
</script>
@endpush

@push('styles')
<style>
    .landing-wrap { max-width: 960px; margin: 0 auto; padding: 0 16px 80px; }
    /* Hero */
    .landing-hero { text-align: center; padding: 48px 20px 40px; }
    .landing-hero h1 { font-size: 36px; font-weight: 800; color: #1a1a1a; margin: 0 0 16px; line-height: 1.2; }
    .landing-hero h1 span { color: #7b4397; }
    .landing-hero p { font-size: 18px; color: #555; max-width: 620px; margin: 0 auto 28px; line-height: 1.6; }
    .hero-badges { display: flex; flex-wrap: wrap; gap: 10px; justify-content: center; margin-bottom: 32px; }
    .hero-badge { background: #f3edf7; color: #5b287a; border-radius: 99px; padding: 6px 16px; font-size: 13px; font-weight: 600; }
    .cta-btn { display: inline-block; background: linear-gradient(135deg, #7b4397, #5b287a); color: #fff !important; text-decoration: none; border-radius: 12px; padding: 16px 40px; font-size: 18px; font-weight: 700; transition: opacity .2s; box-shadow: 0 4px 16px rgba(123,67,151,.35); }
    .cta-btn:hover { opacity: .9; text-decoration: none; }
    .cta-sub { font-size: 13px; color: #999; margin-top: 10px; }
    /* How it works */
    .section-title { font-size: 26px; font-weight: 800; color: #1a1a1a; text-align: center; margin: 0 0 8px; }
    .section-sub { text-align: center; color: #777; font-size: 15px; margin-bottom: 32px; }
    .steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 60px; }
    .step-card { background: #fff; border-radius: 14px; padding: 28px 22px; text-align: center; box-shadow: 0 2px 12px rgba(0,0,0,.07); border-top: 4px solid #7b4397; }
    .step-number { width: 40px; height: 40px; background: linear-gradient(135deg, #7b4397, #5b287a); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 18px; font-weight: 800; margin: 0 auto 14px; }
    .step-card h3 { font-size: 16px; font-weight: 700; color: #1a1a1a; margin: 0 0 8px; }
    .step-card p { font-size: 14px; color: #666; line-height: 1.6; margin: 0; }
    /* Features */
    .features-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; margin-bottom: 60px; }
    .feature-item { background: #fff; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,.06); display: flex; gap: 14px; align-items: flex-start; }
    .feature-icon { font-size: 28px; flex-shrink: 0; }
    .feature-text h4 { font-size: 15px; font-weight: 700; color: #1a1a1a; margin: 0 0 4px; }
    .feature-text p { font-size: 13px; color: #666; line-height: 1.5; margin: 0; }
    /* FAQ */
    .faq-list { margin-bottom: 60px; }
    .faq-item { background: #fff; border-radius: 12px; margin-bottom: 10px; box-shadow: 0 1px 6px rgba(0,0,0,.06); overflow: hidden; }
    .faq-q { padding: 16px 20px; font-weight: 700; font-size: 15px; color: #1a1a1a; cursor: pointer; display: flex; justify-content: space-between; align-items: center; }
    .faq-q::after { content: '+'; font-size: 22px; color: #7b4397; font-weight: 400; transition: transform .2s; }
    .faq-item.open .faq-q::after { transform: rotate(45deg); }
    .faq-a { display: none; padding: 0 20px 16px; font-size: 14px; color: #555; line-height: 1.7; border-top: 1px solid #f3f4f6; padding-top: 14px; }
    .faq-item.open .faq-a { display: block; }
    /* Second CTA */
    .cta-section { background: linear-gradient(135deg, #7b4397, #5b287a); border-radius: 16px; padding: 40px; text-align: center; color: #fff; }
    .cta-section h2 { font-size: 28px; font-weight: 800; margin: 0 0 10px; }
    .cta-section p { font-size: 15px; opacity: .85; margin: 0 0 24px; }
    .cta-btn-white { display: inline-block; background: #fff; color: #5b287a !important; text-decoration: none; border-radius: 10px; padding: 14px 36px; font-size: 16px; font-weight: 700; transition: opacity .2s; }
    .cta-btn-white:hover { opacity: .9; text-decoration: none; }
    /* Language switch */
    .lang-row { text-align: right; padding: 10px 0 0; }
    .lang-row a { font-size: 13px; color: #7b4397; border: 1px solid #d1bfe0; border-radius: 6px; padding: 4px 10px; text-decoration: none; }
    .lang-row a:hover { background: #f3edf7; }
    @media(max-width:680px) {
        .steps-grid { grid-template-columns: 1fr; }
        .features-grid { grid-template-columns: 1fr; }
        .landing-hero h1 { font-size: 26px; }
    }
</style>
@endpush

@section('content')
<div class="landing-wrap">

    <div class="lang-row">
        @if($isPt)
            <a href="{{ route('menu.landing.en') }}">🇬🇧 See in English</a>
        @else
            <a href="{{ route('menu.landing.pt') }}">🇧🇷 Ver em Português</a>
        @endif
    </div>

    {{-- Hero --}}
    <div class="landing-hero">
        <div style="font-size:56px; margin-bottom:16px;">🍽️</div>
        <h1>
            @if($isPt)
                Crie o <span>Cardápio Digital</span> do seu<br>Restaurante com QR Code
            @else
                Create Your Restaurant's<br><span>Digital Menu</span> with QR Code
            @endif
        </h1>
        <p>
            {{ $isPt
              ? 'Crie um cardápio profissional e bonito em minutos. Gera automaticamente um link exclusivo e um QR Code para seus clientes escanearem.'
              : 'Build a professional, beautiful menu in minutes. Automatically generates an exclusive link and a QR Code for your customers to scan.' }}
        </p>
        <div class="hero-badges">
            @if($isPt)
                <span class="hero-badge">✅ 100% Gratuito</span>
                <span class="hero-badge">🔒 Sem cadastro</span>
                <span class="hero-badge">📱 QR Code automático</span>
                <span class="hero-badge">✏️ Link de edição exclusivo</span>
                <span class="hero-badge">📲 Responsivo para mobile</span>
            @else
                <span class="hero-badge">✅ 100% Free</span>
                <span class="hero-badge">🔒 No signup</span>
                <span class="hero-badge">📱 Automatic QR Code</span>
                <span class="hero-badge">✏️ Exclusive edit link</span>
                <span class="hero-badge">📲 Mobile responsive</span>
            @endif
        </div>
        <a href="{{ $isPt ? route('menu.create.pt') : route('menu.create.en') }}" class="cta-btn">
            {{ $isPt ? '🚀 Criar Cardápio Grátis' : '🚀 Create Free Menu' }}
        </a>
        <div class="cta-sub">
            {{ $isPt ? 'Sem cadastro · Sem cartão de crédito · Pronto em 5 minutos' : 'No signup · No credit card · Ready in 5 minutes' }}
        </div>
    </div>

    {{-- How it works --}}
    <div style="margin-bottom:16px;">
        <h2 class="section-title">{{ $isPt ? 'Como funciona' : 'How it works' }}</h2>
        <p class="section-sub">{{ $isPt ? '3 passos simples para ter seu cardápio digital' : '3 simple steps to get your digital menu' }}</p>
    </div>
    <div class="steps-grid">
        <div class="step-card">
            <div class="step-number">1</div>
            <h3>{{ $isPt ? 'Preencha os dados' : 'Fill in your details' }}</h3>
            <p>{{ $isPt ? 'Adicione nome do restaurante, endereço, telefone, redes sociais e escolha as cores do cardápio.' : 'Add restaurant name, address, phone, social media and choose menu colours.' }}</p>
        </div>
        <div class="step-card">
            <div class="step-number">2</div>
            <h3>{{ $isPt ? 'Monte o cardápio' : 'Build your menu' }}</h3>
            <p>{{ $isPt ? 'Crie seções (Entradas, Pratos, Bebidas) e adicione os itens com nome, preço, descrição e foto.' : 'Create sections (Starters, Mains, Drinks) and add items with name, price, description and photo.' }}</p>
        </div>
        <div class="step-card">
            <div class="step-number">3</div>
            <h3>{{ $isPt ? 'Receba o link + QR Code' : 'Get link + QR Code' }}</h3>
            <p>{{ $isPt ? 'Instantaneamente gera um URL público do cardápio e um QR Code para imprimir e colocar nas mesas.' : 'Instantly generates a public menu URL and a QR Code to print and place on tables.' }}</p>
        </div>
    </div>

    {{-- Features --}}
    <div style="margin-bottom:16px;">
        <h2 class="section-title">{{ $isPt ? 'Recursos incluídos' : 'Included features' }}</h2>
        <p class="section-sub">{{ $isPt ? 'Tudo o que você precisa, sem custo algum' : 'Everything you need, at no cost' }}</p>
    </div>
    <div class="features-grid">
        @if($isPt)
        <div class="feature-item">
            <div class="feature-icon">📲</div>
            <div class="feature-text">
                <h4>Cardápio 100% responsivo</h4>
                <p>Funciona perfeitamente em celular, tablet e desktop. Os clientes abrem direto pelo QR Code.</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">🎨</div>
            <div class="feature-text">
                <h4>Personalização de cores</h4>
                <p>Escolha as cores do cardápio para combinar com a identidade visual do seu restaurante.</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">🌿</div>
            <div class="feature-text">
                <h4>Etiquetas dietéticas</h4>
                <p>Marque itens como Vegano, Vegetariano, Sem Glúten ou Picante para facilitar a escolha dos clientes.</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">✏️</div>
            <div class="feature-text">
                <h4>Edição sem login</h4>
                <p>Recebe um link secreto de edição. Altere preços, adicione itens ou remova seções quando quiser.</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">📸</div>
            <div class="feature-text">
                <h4>Fotos dos pratos</h4>
                <p>Adicione fotos a cada item do cardápio via URL. Fotos aumentam as vendas em até 30%.</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">📱</div>
            <div class="feature-text">
                <h4>QR Code para download</h4>
                <p>Baixe o QR Code em PNG e imprima nas mesas, balcão ou fachada do restaurante.</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">⭐</div>
            <div class="feature-text">
                <h4>Itens em destaque</h4>
                <p>Marque os pratos mais populares ou especiais do dia com a etiqueta de destaque.</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">💬</div>
            <div class="feature-text">
                <h4>Botão WhatsApp direto</h4>
                <p>Se tiver WhatsApp, o cardápio mostra um botão flutuante para os clientes entrarem em contato.</p>
            </div>
        </div>
        @else
        <div class="feature-item">
            <div class="feature-icon">📲</div>
            <div class="feature-text">
                <h4>100% responsive menu</h4>
                <p>Works perfectly on mobile, tablet and desktop. Customers open it directly by scanning the QR Code.</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">🎨</div>
            <div class="feature-text">
                <h4>Colour customisation</h4>
                <p>Choose menu colours to match your restaurant's visual identity and branding.</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">🌿</div>
            <div class="feature-text">
                <h4>Dietary labels</h4>
                <p>Tag items as Vegan, Vegetarian, Gluten-Free or Spicy to help customers make their choice.</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">✏️</div>
            <div class="feature-text">
                <h4>Edit without login</h4>
                <p>You receive a secret edit link. Change prices, add items or remove sections at any time.</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">📸</div>
            <div class="feature-text">
                <h4>Dish photos</h4>
                <p>Add photos to each menu item via URL. Photos can increase sales by up to 30%.</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">📱</div>
            <div class="feature-text">
                <h4>Downloadable QR Code</h4>
                <p>Download the QR Code as PNG and print it on tables, counter or restaurant entrance.</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">⭐</div>
            <div class="feature-text">
                <h4>Featured items</h4>
                <p>Mark your most popular dishes or daily specials with the featured label.</p>
            </div>
        </div>
        <div class="feature-item">
            <div class="feature-icon">💬</div>
            <div class="feature-text">
                <h4>Direct WhatsApp button</h4>
                <p>If you have WhatsApp, the menu shows a floating button for customers to contact you.</p>
            </div>
        </div>
        @endif
    </div>

    {{-- FAQ --}}
    <div style="margin-bottom:16px;">
        <h2 class="section-title">{{ $isPt ? 'Perguntas frequentes' : 'Frequently asked questions' }}</h2>
        <p class="section-sub">{{ $isPt ? 'Tudo o que você precisa saber' : 'Everything you need to know' }}</p>
    </div>
    <div class="faq-list">
        @if($isPt)
        <div class="faq-item">
            <div class="faq-q">É gratuito criar um cardápio digital?</div>
            <div class="faq-a">Sim, é totalmente gratuito. Não há planos pagos, não há limites de seções ou itens e não precisa de cartão de crédito.</div>
        </div>
        <div class="faq-item">
            <div class="faq-q">Preciso criar uma conta para usar?</div>
            <div class="faq-a">Não. O cardápio é criado sem qualquer cadastro. Você recebe um link exclusivo para editar o cardápio sempre que precisar.</div>
        </div>
        <div class="faq-item">
            <div class="faq-q">Como edito o cardápio depois de criado?</div>
            <div class="faq-a">Ao criar o cardápio, você recebe um link secreto de edição. Guarde esse link com segurança — qualquer pessoa que o tiver pode editar o cardápio.</div>
        </div>
        <div class="faq-item">
            <div class="faq-q">O QR Code é gerado automaticamente?</div>
            <div class="faq-a">Sim. Após criar o cardápio, o QR Code é gerado automaticamente e aponta para o link público do cardápio. Você pode baixá-lo em PNG para imprimir.</div>
        </div>
        <div class="faq-item">
            <div class="faq-q">O cardápio funciona bem no celular?</div>
            <div class="faq-a">Sim. O cardápio público é totalmente responsivo e otimizado para smartphones, que é o dispositivo mais usado pelos clientes para escanear QR Codes.</div>
        </div>
        <div class="faq-item">
            <div class="faq-q">Posso usar para bares, padarias ou cafés?</div>
            <div class="faq-a">Claro! O gerador funciona para qualquer tipo de estabelecimento que queira apresentar produtos com preços: restaurantes, bares, padarias, cafeterias, food trucks, etc.</div>
        </div>
        @else
        <div class="faq-item">
            <div class="faq-q">Is it free to create a digital menu?</div>
            <div class="faq-a">Yes, it is completely free. There are no paid plans, no section or item limits and no credit card required.</div>
        </div>
        <div class="faq-item">
            <div class="faq-q">Do I need to create an account?</div>
            <div class="faq-a">No. The menu is created without any signup. You receive an exclusive link to edit the menu whenever you need.</div>
        </div>
        <div class="faq-item">
            <div class="faq-q">How do I edit the menu after creating it?</div>
            <div class="faq-a">When creating the menu, you receive a secret edit link. Keep it safe — anyone who has this link can edit the menu.</div>
        </div>
        <div class="faq-item">
            <div class="faq-q">Is the QR Code generated automatically?</div>
            <div class="faq-a">Yes. After creating the menu, a QR Code is automatically generated pointing to the public menu link. You can download it as PNG to print.</div>
        </div>
        <div class="faq-item">
            <div class="faq-q">Does the menu work well on mobile?</div>
            <div class="faq-a">Yes. The public menu is fully responsive and optimised for smartphones, which is the most common device customers use to scan QR Codes.</div>
        </div>
        <div class="faq-item">
            <div class="faq-q">Can I use it for bars, bakeries or cafés?</div>
            <div class="faq-a">Absolutely! The generator works for any type of establishment that wants to present products with prices: restaurants, bars, bakeries, cafés, food trucks, etc.</div>
        </div>
        @endif
    </div>

    {{-- Second CTA --}}
    <div class="cta-section">
        <h2>{{ $isPt ? 'Pronto para começar?' : 'Ready to get started?' }}</h2>
        <p>{{ $isPt ? 'Crie o cardápio digital do seu restaurante agora — é grátis e leva menos de 5 minutos.' : 'Create your restaurant\'s digital menu now — it\'s free and takes less than 5 minutes.' }}</p>
        <a href="{{ $isPt ? route('menu.create.pt') : route('menu.create.en') }}" class="cta-btn-white">
            {{ $isPt ? '🍽️ Criar Cardápio Grátis' : '🍽️ Create Free Menu' }}
        </a>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.querySelectorAll('.faq-q').forEach(q => {
    q.addEventListener('click', () => {
        const item = q.closest('.faq-item');
        const wasOpen = item.classList.contains('open');
        document.querySelectorAll('.faq-item').forEach(i => i.classList.remove('open'));
        if (!wasOpen) item.classList.add('open');
    });
});
</script>
@endpush
