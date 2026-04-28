{{-- QR Type Page — used for both EN and PT pages --}}

@extends('layouts.app')

@push('schema')
@php
$webAppSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'WebApplication',
    'name' => config('qrgenerate.name'),
    'url' => config('qrgenerate.url'),
    'applicationCategory' => 'UtilityApplication',
    'operatingSystem' => 'Any',
    'offers' => [
        '@type' => 'Offer',
        'price' => '0',
        'priceCurrency' => 'USD',
    ],
];
@endphp
<script type="application/ld+json">{!! json_encode($webAppSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endpush

@section('content')

    {{-- Breadcrumb --}}
    @include('components.breadcrumb', ['items' => [
        ['label' => ($locale ?? 'en') === 'pt' ? 'Início' : 'Home', 'url' => ($locale ?? 'en') === 'pt' ? url('/pt') : url('/')],
        ['label' => $page['h1']],
    ]])

    {{-- Hero --}}
    <div class="jumbotron text-center">
        <h1>{{ $page['h1'] }}</h1>
        <p>{{ Str::limit(strip_tags($page['intro']), 160) }}</p>
    </div>

    {{-- Intro Text --}}
    <div class="article-section">
        <p class="lead">{!! $page['intro'] !!}</p>
    </div>

    {{-- QR Code Generator --}}
    @include('components.qr-generator', ['type' => $page['qr_type'], 'locale' => $locale ?? 'en'])

    {{-- Steps --}}
    @if(!empty($page['steps']))
    <div class="article-section">
        <h2>{{ ($locale ?? 'en') === 'pt' ? 'Como criar este QR Code' : 'How to Create This QR Code' }}</h2>
        <ol>
            @foreach($page['steps'] as $step)
                <li>{{ $step }}</li>
            @endforeach
        </ol>
    </div>
    @endif

    {{-- Use Cases --}}
    @if(!empty($page['use_cases']))
    <div class="article-section">
        <h2>{{ ($locale ?? 'en') === 'pt' ? 'Casos de uso comuns' : 'Common Use Cases' }}</h2>
        <ul>
            @foreach($page['use_cases'] as $useCase)
                <li>{{ $useCase }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- FAQ --}}
    @if(!empty($page['faqs']))
        @include('components.faq', ['faqs' => $page['faqs'], 'locale' => $locale ?? 'en'])
    @endif

    {{-- Related Pages --}}
    @if(!empty($relatedPages))
        @include('components.related-links', [
            'title' => ($locale ?? 'en') === 'pt' ? 'Páginas relacionadas' : 'Related Pages',
            'links' => $relatedPages,
            'style' => 'list'
        ])
    @endif

    {{-- Popular Tools --}}
    @php
        if (($locale ?? 'en') === 'pt') {
            $popularTools = [
                ['url' => '/pt/qr-code-para-whatsapp', 'title' => 'QR Code para WhatsApp', 'icon' => 'comment'],
                ['url' => '/pt/qr-code-para-wifi', 'title' => 'QR Code para Wi-Fi', 'icon' => 'signal'],
                ['url' => '/pt/qr-code-com-logotipo', 'title' => 'QR Code com Logotipo', 'icon' => 'picture'],
                ['url' => '/pt/qr-code-para-cartao-de-visita', 'title' => 'QR Code para Cartão de Visita', 'icon' => 'user'],
                ['url' => '/pt/qr-code-para-menu-de-restaurante', 'title' => 'QR Code para Menu de Restaurante', 'icon' => 'cutlery'],
                ['url' => '/pt/gerador-de-qr-code-privado', 'title' => 'Gerador de QR Code Privado', 'icon' => 'lock'],
            ];
            $popularTitle = 'Ferramentas populares de QR Code';
        } else {
            $popularTools = [
                ['url' => '/qr-code-for-whatsapp', 'title' => 'QR Code for WhatsApp', 'icon' => 'comment'],
                ['url' => '/qr-code-for-wifi', 'title' => 'QR Code for Wi-Fi', 'icon' => 'signal'],
                ['url' => '/qr-code-with-logo', 'title' => 'QR Code with Logo', 'icon' => 'picture'],
                ['url' => '/qr-code-for-business-card', 'title' => 'QR Code for Business Card', 'icon' => 'user'],
                ['url' => '/qr-code-for-restaurant-menu', 'title' => 'QR Code for Restaurant Menu', 'icon' => 'cutlery'],
                ['url' => '/private-qr-code-generator', 'title' => 'Private QR Code Generator', 'icon' => 'lock'],
            ];
            $popularTitle = 'Popular QR Code Tools';
        }
    @endphp
    @include('components.related-links', [
        'title' => $popularTitle,
        'links' => $popularTools,
        'style' => 'grid'
    ])

    {{-- CTA --}}
    <div class="jumbotron text-center" style="margin-top:30px;">
        <h2>{{ ($locale ?? 'en') === 'pt' ? 'Pronto para criar o seu QR Code?' : 'Ready to Create Your QR Code?' }}</h2>
        <p>{{ ($locale ?? 'en') === 'pt' ? 'Vá ao gerador acima e crie o seu QR Code grátis em segundos.' : 'Scroll up to the generator and create your free QR code in seconds.' }}</p>
        <a href="#qr-text" class="btn btn-purple btn-lg">
            {{ ($locale ?? 'en') === 'pt' ? 'Criar QR Code Agora' : 'Create QR Code Now' }}
        </a>
    </div>

@endsection
