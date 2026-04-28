@extends('layouts.app')

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebPage",
  "name": "{{ $seo['title'] }}",
  "description": "{{ $seo['description'] }}",
  "url": "{{ $seo['canonical'] }}"
}
</script>
@endpush

@section('content')
    @include('components.breadcrumb', ['items' => [
        ['label' => 'Home', 'url' => url('/')],
        ['label' => 'About Us'],
    ]])

    <article class="article-section">
        <header style="margin-bottom:30px;">
            <h1>About QrGenerate</h1>
        </header>

        <div class="article-body">
            <p class="lead"><strong>QrGenerate</strong> was built with a simple mission: to provide a fast, private, and 100% free QR code generator that respects the user.</p>

            <div class="row" style="margin-top: 40px; margin-bottom: 40px;">
                <div class="col-md-4 text-center">
                    <span class="glyphicon glyphicon-flash" style="font-size: 40px; color: #7b4397; margin-bottom: 15px;"></span>
                    <h3 style="margin-top: 0;">Simplicity</h3>
                    <p>We eliminated the clutter. No sign-up walls, no complex menus, and no hidden subscriptions. Just enter your data and get your QR code instantly.</p>
                </div>
                <div class="col-md-4 text-center">
                    <span class="glyphicon glyphicon-lock" style="font-size: 40px; color: #7b4397; margin-bottom: 15px;"></span>
                    <h3 style="margin-top: 0;">Privacy First</h3>
                    <p>Unlike other generators that send your data to their servers to create an image, QrGenerate builds the QR code directly in your browser. We never see your data.</p>
                </div>
                <div class="col-md-4 text-center">
                    <span class="glyphicon glyphicon-ok-circle" style="font-size: 40px; color: #7b4397; margin-bottom: 15px;"></span>
                    <h3 style="margin-top: 0;">Truly Free</h3>
                    <p>We generate static QR codes that do not expire. There are no scan limits, and we never place our watermark on your generated codes.</p>
                </div>
            </div>

            <h3>Our Story</h3>
            <p>We noticed that most QR code generators online bait users with "free" offers, only to ask for an email address or credit card before downloading the final image. Worse, many of these services use dynamic codes by default, meaning the QR codes stop working if the user doesn't pay a monthly subscription.</p>
            <p>We created QrGenerate as an alternative. Our tool generates static, permanent QR codes using modern web technologies to process everything securely on your device. Whether you need a simple URL link, a Wi-Fi login code, or a branded vCard for your business, QrGenerate provides it cleanly and without restrictions.</p>

            <div class="jumbotron text-center" style="margin-top: 40px; padding: 30px;">
                <h2>Try it yourself</h2>
                <p>Experience the fastest way to generate a secure QR code.</p>
                <a href="{{ url('/') }}" class="btn btn-purple btn-lg">Generate a Free QR Code</a>
            </div>
        </div>
    </article>
@endsection
