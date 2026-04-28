<!DOCTYPE html>
<html lang="{{ $locale ?? 'en' }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="google-adsense-account" content="ca-pub-2118765549976668">

    {{-- Google AdSense --}}
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-2118765549976668"
        crossorigin="anonymous"></script>

    {{-- Dynamic SEO Meta Tags --}}
    @include('components.seo', ['seo' => $seo ?? []])

    {{-- Google Analytics --}}
    @if(config('qrgenerate.analytics_id'))
        <script async src="https://www.googletagmanager.com/gtag/js?id={{ config('qrgenerate.analytics_id') }}"></script>
        <script>
            window.dataLayer = window.dataLayer || [];
            function gtag() { dataLayer.push(arguments); }
            gtag('js', new Date());
            gtag('config', '{{ config('qrgenerate.analytics_id') }}');
        </script>
    @endif

    {{-- Page-specific structured data --}}
    @stack('schema')

    {{-- Bootstrap 3.3.7 CSS --}}
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

    {{-- Site-wide custom CSS --}}
    <style>
        body {
            background-color: #f8f5fa;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #333;
        }

        /* Navbar */
        .navbar-custom {
            background-image: linear-gradient(to bottom, #7b4397 0%, #5b287a 100%);
            border-color: #4a1c64;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            border-radius: 0;
        }

        .navbar-custom .navbar-brand {
            color: #fff;
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            font-size: 24px;
        }

        /* Jumbotron */
        .jumbotron {
            background-image: linear-gradient(to bottom, #8a53a6 0%, #6b3488 100%);
            color: white;
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.6);
            border-radius: 6px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 5px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }

        /* Panels */
        .panel-purple {
            border-color: #d1bfe0;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .panel-purple>.panel-heading {
            background-image: linear-gradient(to bottom, #f3edf7 0%, #e1d2eb 100%);
            color: #5b287a;
            border-color: #d1bfe0;
            font-weight: bold;
        }

        /* Buttons */
        .btn-purple {
            color: #ffffff;
            background-color: #7b4397;
            border-color: #5b287a;
            background-image: linear-gradient(to bottom, #8a53a6 0%, #6b3488 100%);
            text-shadow: 0 -1px 0 rgba(0, 0, 0, 0.25);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, 0.15), 0 1px 1px rgba(0, 0, 0, 0.075);
            transition: all 0.2s;
        }

        .btn-purple:hover,
        .btn-purple:focus {
            background-color: #5b287a;
            background-position: 0 -15px;
            color: white;
        }

        /* QR Code Container */
        #qrcode-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 250px;
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 15px;
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
        }

        .color-picker-group {
            display: flex;
            gap: 15px;
            margin-bottom: 15px;
        }

        .color-picker-group div {
            display: flex;
            flex-direction: column;
        }

        input[type="color"] {
            width: 50px;
            height: 35px;
            border: 1px solid #ccc;
            border-radius: 4px;
            cursor: pointer;
        }

        #action-buttons {
            display: none;
            margin-top: 15px;
        }

        #embed-code {
            display: none;
            margin-top: 10px;
            font-family: Menlo, Monaco, Consolas, "Courier New", monospace;
            font-size: 12px;
        }

        /* Article Sections */
        .article-section {
            background: white;
            padding: 40px;
            border-radius: 6px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            margin-top: 40px;
            margin-bottom: 40px;
            border-top: 5px solid #7b4397;
        }

        .article-section h2 {
            color: #5b287a;
            font-weight: bold;
            margin-top: 0;
            margin-bottom: 20px;
            font-size: 28px;
        }

        .article-section h3 {
            color: #7b4397;
            font-weight: bold;
            margin-top: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
        }

        .article-section p,
        .article-section li {
            line-height: 1.6;
            font-size: 16px;
            color: #444;
        }

        .article-section ul {
            margin-top: 10px;
            margin-bottom: 20px;
        }

        .article-section li {
            margin-bottom: 8px;
        }

        /* Tip Box */
        .tip-box {
            background-color: #f3edf7;
            border-left: 5px solid #7b4397;
            padding: 15px 20px;
            margin: 25px 0;
            border-radius: 0 4px 4px 0;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .tip-box p {
            margin: 0;
            color: #4a1c64;
        }
    </style>

    {{-- Page-specific styles --}}
    @stack('styles')
</head>

<body>

    {{-- Header --}}
    @include('components.header')

    {{-- Main Content --}}
    <div class="container">
        @yield('content')
    </div>

    {{-- Footer --}}
    @include('components.footer')

    {{-- EasyQRCodeJS — loaded once, available to all pages --}}
    <script src="https://unpkg.com/easyqrcodejs/dist/easy.qrcode.min.js"></script>
    <script src="{{ asset('assets/js/qr-generator.js') }}"></script>

    {{-- Page-specific scripts --}}
    @stack('scripts')

</body>

</html>