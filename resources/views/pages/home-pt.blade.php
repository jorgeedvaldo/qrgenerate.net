@extends('layouts.app')

@push('schema')
{{-- Web Application Schema --}}
@php
$webAppSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'WebApplication',
    'name' => config('qrgenerate.name'),
    'url' => config('qrgenerate.url'),
    'applicationCategory' => 'UtilityApplication',
    'operatingSystem' => 'Any',
    'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD'],
    'description' => config('qrgenerate.seo.description'),
];
@endphp
<script type="application/ld+json">{!! json_encode($webAppSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endpush

@section('content')

    {{-- Hero Section --}}
    <div class="jumbotron text-center" style="margin-bottom: 40px;">
        <h1>Gerador de QR Code Grátis com Logotipo</h1>
        <p class="lead" style="max-width: 800px; margin: 0 auto 20px;">
            Crie QR Codes personalizados para links, WhatsApp, Wi-Fi, cartões de visita, menus e muito mais. 
            Sem cadastro e gerado directamente no seu navegador.
        </p>
        <div>
            <a href="#generator" class="btn btn-purple btn-lg" style="margin: 5px;">Criar QR Code</a>
            <a href="#qr-types" class="btn btn-default btn-lg" style="margin: 5px; border: 2px solid white; color: white; background: transparent;">Explorar Tipos de QR Code</a>
        </div>
    </div>

    {{-- QR Code Generator Component --}}
    <div id="generator" style="margin-bottom: 60px;">
        @include('components.qr-generator', ['type' => 'url', 'locale' => 'pt'])
    </div>

    {{-- Section: Create QR codes for anything --}}
    <div id="qr-types" class="article-section text-center">
        <h2>Crie QR Codes para qualquer coisa</h2>
        <p class="lead" style="margin-bottom: 40px;">Escolha o tipo de QR Code que pretende gerar.</p>
        
        <div class="row">
            @php
                $types = [
                    ['url' => '/pt/gerador-de-qr-code-gratis', 'icon' => 'globe', 'title' => 'URL de Website', 'desc' => 'Ligue a qualquer página web'],
                    ['url' => '/pt/qr-code-para-whatsapp', 'icon' => 'comment', 'title' => 'WhatsApp', 'desc' => 'Inicie um chat instantaneamente'],
                    ['url' => '/pt/qr-code-para-wifi', 'icon' => 'signal', 'title' => 'Wi-Fi', 'desc' => 'Ligação automática à rede'],
                    ['url' => '/pt/qr-code-para-cartao-de-visita', 'icon' => 'user', 'title' => 'Cartão de Visita', 'desc' => 'Partilhe os seus contactos vCard'],
                    ['url' => '/pt/qr-code-para-menu-de-restaurante', 'icon' => 'cutlery', 'title' => 'Menu de Restaurante', 'desc' => 'Menus digitais sem contacto'],
                    ['url' => '/pt/qr-code-para-email', 'icon' => 'envelope', 'title' => 'Email', 'desc' => 'Pré-preencha o endereço de email'],
                    ['url' => '/pt/qr-code-para-sms', 'icon' => 'phone', 'title' => 'SMS', 'desc' => 'Pré-preencha mensagens de texto'],
                    ['url' => '/pt/qr-code-para-localizacao', 'icon' => 'map-marker', 'title' => 'Localização', 'desc' => 'Abra o Google Maps'],
                    ['url' => '/pt/qr-code-para-pdf', 'icon' => 'file', 'title' => 'PDF', 'desc' => 'Ligue a documentos e ficheiros'],
                    ['url' => '/pt/qr-code-para-instagram', 'icon' => 'camera', 'title' => 'Redes Sociais', 'desc' => 'Ligue a perfis de Instagram'],
                ];
            @endphp

            @foreach($types as $t)
            <div class="col-md-3 col-sm-4 col-xs-6" style="margin-bottom: 20px;">
                <a href="{{ url($t['url']) }}" style="display: block; padding: 20px 10px; background: #f9f9f9; border-radius: 6px; text-decoration: none; border: 1px solid #eee; transition: all 0.2s;">
                    <span class="glyphicon glyphicon-{{ $t['icon'] }}" style="font-size: 24px; color: #7b4397; margin-bottom: 10px;"></span>
                    <h4 style="color: #333; margin: 0 0 5px;">{{ $t['title'] }}</h4>
                    <p style="color: #777; font-size: 13px; margin: 0;">{{ $t['desc'] }}</p>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Section: Why use QrGenerate? --}}
    <div class="article-section">
        <h2 class="text-center" style="margin-bottom: 40px;">Porquê usar o QrGenerate?</h2>
        
        <div class="row">
            <div class="col-md-4">
                <div class="tip-box" style="margin-top: 0;">
                    <h4 style="color: #5b287a; font-weight: bold;"><span class="glyphicon glyphicon-ok-circle"></span> Uso gratuito</h4>
                    <p style="font-size: 14px;">Sem taxas ocultas, sem subscrições e sem limites para a quantidade de QR Codes que pode gerar.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tip-box" style="margin-top: 0;">
                    <h4 style="color: #5b287a; font-weight: bold;"><span class="glyphicon glyphicon-user"></span> Sem cadastro</h4>
                    <p style="font-size: 14px;">Salte os formulários de registo. Gere e descarregue os seus QR Codes imediatamente sem dar o seu email.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tip-box" style="margin-top: 0;">
                    <h4 style="color: #5b287a; font-weight: bold;"><span class="glyphicon glyphicon-lock"></span> Privacidade em 1º lugar</h4>
                    <p style="font-size: 14px;">Os seus dados nunca saem do seu telemóvel ou PC. O QR Code é gerado inteiramente no seu navegador com JavaScript.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="tip-box">
                    <h4 style="color: #5b287a; font-weight: bold;"><span class="glyphicon glyphicon-picture"></span> Cores e logótipo</h4>
                    <p style="font-size: 14px;">Personalize o seu QR Code. Altere as cores de fundo e principal, e adicione o logótipo da sua empresa ao centro.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tip-box">
                    <h4 style="color: #5b287a; font-weight: bold;"><span class="glyphicon glyphicon-print"></span> Pronto a imprimir</h4>
                    <p style="font-size: 14px;">Descarregue PNGs de alta qualidade ou vectores SVG redimensionáveis, ideais para cartões, montras e pósteres.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tip-box">
                    <h4 style="color: #5b287a; font-weight: bold;"><span class="glyphicon glyphicon-flash"></span> Rápido e simples</h4>
                    <p style="font-size: 14px;">Sem menus complexos. Veja a pré-visualização actualizar em tempo real à medida que escreve e personaliza.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Section: How it works --}}
    <div class="jumbotron" style="background: transparent; color: #333; box-shadow: none; border: 1px solid #ddd; padding-top: 40px; padding-bottom: 40px;">
        <h2 class="text-center" style="margin-bottom: 40px; color: #5b287a; font-weight: bold;">Como funciona</h2>
        <div class="row text-center">
            <div class="col-md-3 col-sm-6">
                <h1 style="color: #7b4397; font-size: 60px; margin: 0;">1</h1>
                <h4>Escolha o tipo</h4>
                <p class="text-muted">Seleccione URL, WhatsApp, Wi-Fi, etc.</p>
            </div>
            <div class="col-md-3 col-sm-6">
                <h1 style="color: #7b4397; font-size: 60px; margin: 0;">2</h1>
                <h4>Insira o conteúdo</h4>
                <p class="text-muted">Preencha as informações necessárias.</p>
            </div>
            <div class="col-md-3 col-sm-6">
                <h1 style="color: #7b4397; font-size: 60px; margin: 0;">3</h1>
                <h4>Personalize o design</h4>
                <p class="text-muted">Escolha cores e adicione um logótipo.</p>
            </div>
            <div class="col-md-3 col-sm-6">
                <h1 style="color: #7b4397; font-size: 60px; margin: 0;">4</h1>
                <h4>Descarregue ou imprima</h4>
                <p class="text-muted">Exporte em formato PNG ou SVG.</p>
            </div>
        </div>
    </div>

    {{-- Section: FAQ --}}
    @php
        $homeFaqs = [
            ['question' => 'O QrGenerate é mesmo grátis?', 'answer' => 'Sim! Pode gerar os QR Codes que quiser gratuitamente. Não há limites ocultos, nem períodos de teste e não colocamos a nossa marca d\'água no seu código.'],
            ['question' => 'Estes QR Codes expiram?', 'answer' => 'Não. Nós geramos QR Codes estáticos que codificam os seus dados directamente na imagem. Eles irão funcionar para sempre e não dependem dos nossos servidores.'],
            ['question' => 'Porque é que isto é mais privado do que outros geradores?', 'answer' => 'A maioria dos geradores envia os seus dados para um servidor deles para criar a imagem. O QrGenerate usa tecnologia moderna de navegadores para construir o QR Code directamente no seu dispositivo. Nós nunca vemos os seus URLs, passwords ou contactos.'],
            ['question' => 'Posso usar os QR Codes para fins comerciais?', 'answer' => 'Com certeza. Tem totais direitos comerciais para usar os QR Codes gerados nas embalagens dos seus produtos, materiais de marketing, publicidade em TV e muito mais.'],
            ['question' => 'O meu logótipo vai impedir a leitura do QR Code?', 'answer' => 'Não. Nós usamos o nível de correcção de erros mais alto (Nível H), o que garante que o seu QR Code continua perfeitamente legível mesmo quando até 30% dele está coberto por um logótipo.']
        ];
    @endphp
    <div style="margin-bottom: 40px;">
        @include('components.faq', ['faqs' => $homeFaqs, 'locale' => 'pt'])
    </div>

    {{-- Section: Recent Articles --}}
    @if(!empty($recentArticles) && count($recentArticles) > 0)
    <div class="article-section">
        <h2 class="text-center" style="margin-bottom: 40px;">Saiba mais sobre QR Codes</h2>
        <div class="row">
            @foreach($recentArticles as $article)
                <div class="col-md-4">
                    <div class="panel panel-default" style="border-color: #eee;">
                        @if(!empty($article['cover']))
                            <img src="{{ url($article['cover']) }}" alt="{{ $article['title'] }}" style="width: 100%; height: 160px; object-fit: cover; border-top-left-radius: 4px; border-top-right-radius: 4px;">
                        @endif
                        <div class="panel-body">
                            <h4 style="margin-top: 0;"><a href="{{ url('/pt/artigos/' . $article['slug']) }}" style="color: #5b287a;">{{ $article['title'] }}</a></h4>
                            <p class="text-muted" style="font-size: 13px;">{{ Str::limit($article['description'], 100) }}</p>
                            <a href="{{ url('/pt/artigos/' . $article['slug']) }}" class="btn btn-default btn-sm">Ler artigo</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center" style="margin-top: 15px;">
            <a href="{{ url('/pt/artigos') }}" class="btn btn-default">Ver todos os artigos</a>
        </div>
    </div>
    @endif

    {{-- Final CTA --}}
    <div class="jumbotron text-center" style="margin-top: 40px; margin-bottom: 0;">
        <h2>Pronto para criar o seu QR Code?</h2>
        <p>É rápido, grátis e totalmente privado.</p>
        <a href="#generator" class="btn btn-purple btn-lg" style="margin-top: 15px;">Criar QR Code Agora</a>
    </div>

@endsection

@push('styles')
<style>
    /* Hover effects for grid cards */
    #qr-types a:hover {
        background: #f0e6f5;
        border-color: #d1bfe0;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.05);
    }
</style>
@endpush
