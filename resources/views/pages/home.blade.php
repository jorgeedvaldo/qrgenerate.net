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
        <h1>Free QR Code Generator with Logo</h1>
        <p class="lead" style="max-width: 800px; margin: 0 auto 20px;">
            Create custom QR codes for links, WhatsApp, Wi-Fi, business cards, menus and more. 
            No signup required. Generated privately in your browser.
        </p>
        <div>
            <a href="#generator" class="btn btn-purple btn-lg" style="margin: 5px;">Create QR Code</a>
            <a href="#qr-types" class="btn btn-default btn-lg" style="margin: 5px; border: 2px solid white; color: white; background: transparent;">Explore QR Code types</a>
        </div>
    </div>

    {{-- QR Code Generator Component --}}
    <div id="generator" style="margin-bottom: 60px;">
        @include('components.qr-generator', ['type' => 'url', 'locale' => 'en'])
    </div>

    {{-- Section: Create QR codes for anything --}}
    <div id="qr-types" class="article-section text-center">
        <h2>Create QR codes for anything</h2>
        <p class="lead" style="margin-bottom: 40px;">Choose the type of QR code you want to generate.</p>
        
        <div class="row">
            @php
                $types = [
                    ['url' => '/free-qr-code-generator', 'icon' => 'globe', 'title' => 'Website URL', 'desc' => 'Link to any web page'],
                    ['url' => '/qr-code-for-whatsapp', 'icon' => 'comment', 'title' => 'WhatsApp', 'desc' => 'Start a chat instantly'],
                    ['url' => '/qr-code-for-wifi', 'icon' => 'signal', 'title' => 'Wi-Fi', 'desc' => 'Auto-connect to networks'],
                    ['url' => '/qr-code-for-business-card', 'icon' => 'user', 'title' => 'Business Card', 'desc' => 'Share vCard details'],
                    ['url' => '/qr-code-for-restaurant-menu', 'icon' => 'cutlery', 'title' => 'Restaurant Menu', 'desc' => 'Digital contactless menus'],
                    ['url' => '/qr-code-for-email', 'icon' => 'envelope', 'title' => 'Email', 'desc' => 'Pre-fill email address'],
                    ['url' => '/qr-code-for-sms', 'icon' => 'phone', 'title' => 'SMS', 'desc' => 'Pre-fill text messages'],
                    ['url' => '/qr-code-for-location', 'icon' => 'map-marker', 'title' => 'Location', 'desc' => 'Open Google Maps'],
                    ['url' => '/qr-code-for-pdf', 'icon' => 'file', 'title' => 'PDF', 'desc' => 'Link to documents'],
                    ['url' => '/qr-code-for-instagram', 'icon' => 'camera', 'title' => 'Social Media', 'desc' => 'Link to Instagram profiles'],
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
        <h2 class="text-center" style="margin-bottom: 40px;">Why use QrGenerate?</h2>
        
        <div class="row">
            <div class="col-md-4">
                <div class="tip-box" style="margin-top: 0;">
                    <h4 style="color: #5b287a; font-weight: bold;"><span class="glyphicon glyphicon-ok-circle"></span> Free to use</h4>
                    <p style="font-size: 14px;">No hidden fees, no subscriptions, and no limits on how many QR codes you can generate.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tip-box" style="margin-top: 0;">
                    <h4 style="color: #5b287a; font-weight: bold;"><span class="glyphicon glyphicon-user"></span> No signup</h4>
                    <p style="font-size: 14px;">Skip the registration forms. Generate and download your QR codes instantly without providing an email.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tip-box" style="margin-top: 0;">
                    <h4 style="color: #5b287a; font-weight: bold;"><span class="glyphicon glyphicon-lock"></span> Privacy-first</h4>
                    <p style="font-size: 14px;">Your data never leaves your device. The QR code is generated entirely in your browser using JavaScript.</p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="tip-box">
                    <h4 style="color: #5b287a; font-weight: bold;"><span class="glyphicon glyphicon-picture"></span> Custom logo and colors</h4>
                    <p style="font-size: 14px;">Brand your QR codes. Easily change the foreground and background colors and upload a center logo.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tip-box">
                    <h4 style="color: #5b287a; font-weight: bold;"><span class="glyphicon glyphicon-print"></span> Print-ready</h4>
                    <p style="font-size: 14px;">Download high-quality PNGs or scalable vector SVGs perfect for business cards, flyers, and billboards.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="tip-box">
                    <h4 style="color: #5b287a; font-weight: bold;"><span class="glyphicon glyphicon-flash"></span> Fast and simple</h4>
                    <p style="font-size: 14px;">No complicated menus. See the preview update in real-time as you type and customize.</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Section: How it works --}}
    <div class="jumbotron" style="background: transparent; color: #333; box-shadow: none; border: 1px solid #ddd; padding-top: 40px; padding-bottom: 40px;">
        <h2 class="text-center" style="margin-bottom: 40px; color: #5b287a; font-weight: bold;">How it works</h2>
        <div class="row text-center">
            <div class="col-md-3 col-sm-6">
                <h1 style="color: #7b4397; font-size: 60px; margin: 0;">1</h1>
                <h4>Choose QR type</h4>
                <p class="text-muted">Select URL, WhatsApp, Wi-Fi, etc.</p>
            </div>
            <div class="col-md-3 col-sm-6">
                <h1 style="color: #7b4397; font-size: 60px; margin: 0;">2</h1>
                <h4>Enter your content</h4>
                <p class="text-muted">Fill in the required information.</p>
            </div>
            <div class="col-md-3 col-sm-6">
                <h1 style="color: #7b4397; font-size: 60px; margin: 0;">3</h1>
                <h4>Customize design</h4>
                <p class="text-muted">Pick colors and upload a logo.</p>
            </div>
            <div class="col-md-3 col-sm-6">
                <h1 style="color: #7b4397; font-size: 60px; margin: 0;">4</h1>
                <h4>Download or print</h4>
                <p class="text-muted">Export in PNG or SVG format.</p>
            </div>
        </div>
    </div>

    {{-- Section: FAQ --}}
    @php
        $homeFaqs = [
            ['question' => 'Is QrGenerate really free?', 'answer' => 'Yes! You can generate as many QR codes as you want for free. There are no hidden limits, no trial periods, and no watermarks.'],
            ['question' => 'Do these QR codes expire?', 'answer' => 'No. We generate static QR codes that encode your data directly into the image. They will work forever without depending on our servers.'],
            ['question' => 'Why is this more private than other generators?', 'answer' => 'Most generators send your data to a server to create the image. QrGenerate uses modern browser technology to build the QR code directly on your device. We never see your URLs, passwords, or contact details.'],
            ['question' => 'Can I use the QR codes for commercial purposes?', 'answer' => 'Absolutely. You have full commercial rights to use the generated QR codes on product packaging, marketing materials, TV ads, and more.'],
            ['question' => 'Will my logo make the QR code unscannable?', 'answer' => 'We use the highest error correction level (Level H) which ensures your QR code remains fully readable even when up to 30% of it is covered by a logo.']
        ];
    @endphp
    <div style="margin-bottom: 40px;">
        @include('components.faq', ['faqs' => $homeFaqs, 'locale' => 'en'])
    </div>

    {{-- Section: Recent Articles --}}
    @if(!empty($recentArticles) && count($recentArticles) > 0)
    <div class="article-section">
        <h2 class="text-center" style="margin-bottom: 40px;">Learn more about QR Codes</h2>
        <div class="row">
            @foreach($recentArticles as $article)
                <div class="col-md-4">
                    <div class="panel panel-default" style="border-color: #eee;">
                        @if(!empty($article['cover']))
                            <img src="{{ url($article['cover']) }}" alt="{{ $article['title'] }}" style="width: 100%; height: 160px; object-fit: cover; border-top-left-radius: 4px; border-top-right-radius: 4px;">
                        @endif
                        <div class="panel-body">
                            <h4 style="margin-top: 0;"><a href="{{ url('/articles/' . $article['slug']) }}" style="color: #5b287a;">{{ $article['title'] }}</a></h4>
                            <p class="text-muted" style="font-size: 13px;">{{ Str::limit($article['description'], 100) }}</p>
                            <a href="{{ url('/articles/' . $article['slug']) }}" class="btn btn-default btn-sm">Read article</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center" style="margin-top: 15px;">
            <a href="{{ url('/articles') }}" class="btn btn-default">View all articles</a>
        </div>
    </div>
    @endif

    {{-- Final CTA --}}
    <div class="jumbotron text-center" style="margin-top: 40px; margin-bottom: 0;">
        <h2>Ready to create your QR code?</h2>
        <p>It's fast, free, and completely private.</p>
        <a href="#generator" class="btn btn-purple btn-lg" style="margin-top: 15px;">Create QR Code Now</a>
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
