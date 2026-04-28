@extends('layouts.app')

@push('schema')
{{-- JSON-LD Article Schema --}}
@php
$schemaData = [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id' => config('qrgenerate.url') . '/',
    ],
    'headline' => 'The Complete Guide to QR Codes: How They Work, Why They Matter, and How to Create the Perfect One',
    'image' => [config('qrgenerate.url') . '/images/qrgenerate-cover.jpg'],
    'datePublished' => '2023-10-25T08:00:00+08:00',
    'dateModified' => '2024-09-01T08:00:00+08:00',
    'author' => [
        '@type' => 'Organization',
        'name' => config('qrgenerate.seo.author'),
    ],
    'publisher' => [
        '@type' => 'Organization',
        'name' => config('qrgenerate.name'),
        'logo' => [
            '@type' => 'ImageObject',
            'url' => config('qrgenerate.url') . '/images/logo.png',
        ],
    ],
    'description' => 'QR codes have evolved from niche inventory labels into one of the most versatile digital-to-physical bridges in modern marketing. This guide covers everything from technology to design best practices.',
];
@endphp
<script type="application/ld+json">{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
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

    {{-- Hero / Jumbotron --}}
    <div class="jumbotron text-center">
        <h1>Create Your Custom QR Code</h1>
        <p>{{ config('qrgenerate.slogan') }} Generate high-quality QR codes directly in your browser.</p>
    </div>

    {{-- QR Code Generator --}}
    @include('components.qr-generator')

    {{-- Article Section --}}
    <div id="about">
        <div class="article-section">
            <h2>The Complete Guide to QR Codes: How They Work, Why They Matter, and How to Create the Perfect One
            </h2>
            <p class="lead">QR codes have evolved from niche inventory labels into one of the most versatile
                digital-to-physical bridges in modern marketing, healthcare, logistics, and everyday life. This
                guide covers everything you need to know — from the underlying technology to design best practices.
            </p>

            <h3>What is a QR Code?</h3>
            <p>A Quick Response (QR) code is a two-dimensional barcode first invented in 1994 by Masahiro Hara at
                Denso Wave, a Japanese automotive components manufacturer. Unlike traditional one-dimensional
                barcodes that store data in parallel lines, a QR code uses a matrix of black-and-white squares
                arranged in a square grid. This allows it to store significantly more information — up to 7,089
                numeric characters or 4,296 alphanumeric characters — in a compact visual format.</p>
            <p>The three distinctive square "finder patterns" in the corners of a QR code allow any scanner to
                detect orientation instantly, making them readable from any angle and even at up to 30% physical
                damage when using the highest error-correction level (Level H).</p>

            <div class="tip-box">
                <p><strong>Did you know?</strong> QrGenerate uses Error Correction Level H by default, which means
                    your QR code remains fully scannable even if nearly a third of it is covered — perfect for
                    placing logos in the center.</p>
            </div>

            <h3>How does a QR code scanner work?</h3>
            <p>Modern smartphones use their cameras to capture the QR code image in real time. The device's
                image-processing software locates the three finder squares, determines the code's orientation and
                scale, then decodes the binary matrix row by row. The decoded data — usually a URL — is immediately
                presented to the user as a tappable link. This entire process typically takes under half a second.
            </p>

            <h3>Where are QR codes used today?</h3>
            <ul>
                <li><strong>Marketing and advertising</strong> — linking print materials, billboards, and packaging
                    to landing pages, videos, or discount codes.</li>
                <li><strong>Restaurants and hospitality</strong> — contactless digital menus, feedback forms, and
                    Wi-Fi login shortcuts.</li>
                <li><strong>Payments</strong> — mobile payment systems like Alipay, WeChat Pay, and various banking
                    apps rely entirely on QR codes.</li>
                <li><strong>Healthcare</strong> — patient wristbands, medication labels, and vaccine certificates
                    often embed QR codes for instant record access.</li>
                <li><strong>Events and ticketing</strong> — boarding passes, concert tickets, and conference badges
                    use QR codes for fast, fraud-resistant entry.</li>
                <li><strong>Education</strong> — classroom worksheets, textbooks, and museum exhibits link to
                    supplementary content via QR codes.</li>
                <li><strong>Smart packaging</strong> — brands encode product information, authenticity verification,
                    and recycling instructions in QR codes on labels.</li>
            </ul>

            <h3>Static vs. dynamic QR codes</h3>
            <p>A <strong>static QR code</strong> (like those created with QrGenerate) encodes data permanently into
                the visual pattern. The URL or text is baked into the code itself; changing the destination requires
                generating a new code. Static codes are ideal for permanent use cases — business cards, signage,
                product packaging — because they have no expiry date and require no subscription or server.</p>
            <p>A <strong>dynamic QR code</strong> stores a short redirect URL that can be updated after printing.
                This is useful for campaigns where the destination changes frequently, but it depends on a
                third-party service remaining active.</p>

            <h3>Designing an effective QR code</h3>
            <p>The visual design of your QR code significantly impacts both scan rates and brand perception. Here
                are the key principles to follow:</p>
            <ul>
                <li><strong>Maintain sufficient contrast.</strong> The dark modules must contrast sharply against
                    the light background. Aim for at least a 3:1 contrast ratio.</li>
                <li><strong>Keep a quiet zone.</strong> Always leave a border of at least four module widths ("quiet
                    zone") around the code. Without it, scanners struggle to find the edges.</li>
                <li><strong>Size it appropriately.</strong> A QR code should be at least 2 cm × 2 cm for close-range
                    scanning. For billboards or posters viewed from a distance, scale proportionally.</li>
                <li><strong>Choose the right error correction.</strong> Use Level H (30% redundancy) whenever you
                    add a logo or overlay. For clean, logo-free codes, Level M or Q offers a good balance of data
                    density and resilience.</li>
                <li><strong>Test before you print.</strong> Scan your code with multiple devices and apps —
                    including older Android phones — before committing to large print runs.</li>
            </ul>

            <div class="tip-box">
                <p><strong>Pro tip:</strong> Adding a "Scan the code here" label below your QR code increases scan
                    rates by up to 40%, according to multiple field studies. QrGenerate lets you customize this text
                    directly in the Print Label field above.</p>
            </div>

            <h3>Why use QrGenerate?</h3>
            <p>QrGenerate is a fully browser-based QR code generator — no installation, no account, no data sent to
                any server. Your logo image is read locally by your browser and embedded directly into the QR code
                canvas. The result is a high-resolution PNG you can download instantly, print at any size, or copy
                as embeddable HTML for your website.</p>
            <p>Key features include custom dark and light colors (so your code can match your brand palette),
                adjustable print labels with sub-text, logo support with automatic transparent background handling,
                and a clean one-click download workflow.</p>

            <h3>Best practices for printing QR codes</h3>
            <p>When preparing your QR code for print media, keep the following in mind:</p>
            <ul>
                <li>Always download the PNG at the largest size you need. QrGenerate generates at 250×250 px by
                    default; for large-format print, scale up in a vector editor.</li>
                <li>Place a clear call-to-action near the code — "Scan with your camera" or "Scan to learn more"
                    removes hesitation from first-time scanners.</li>
                <li>Avoid placing QR codes on reflective surfaces (glossy laminate, metallic foil) without testing —
                    strong reflections can confuse scanners.</li>
                <li>On dark backgrounds, invert the color scheme: use a white or light code on a dark background,
                    and ensure there is still sufficient quiet zone.</li>
            </ul>

            <h3>Privacy and security considerations</h3>
            <p>Because QR codes are opaque to the human eye, users cannot tell at a glance where a code will send
                them. Always use a recognizable, trustworthy domain as your QR code destination. For physical
                installations in public spaces, check periodically that no one has placed a sticker over your code
                to redirect visitors to a malicious URL — a practice known as "QR code jacking." Educate your
                audience to preview the URL before tapping when in doubt.</p>

            <p style="margin-top:24px; color:#888; font-size:13px;">Last updated: September 2024 &middot; QrGenerate
                &middot; All QR codes are generated locally in your browser. No data is stored or transmitted.</p>
        </div>
    </div>

@endsection
