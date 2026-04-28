@extends('layouts.app')

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebPage",
  "name": "Page Not Found",
  "description": "The page you are looking for does not exist."
}
</script>
@endpush

@section('content')
<div class="jumbotron text-center" style="margin-top: 50px; padding: 60px 20px;">
    <h1 style="font-size: 80px; margin-bottom: 20px;">404</h1>
    <h2>Page Not Found</h2>
    <p style="margin-bottom: 30px;">Oops! The page or QR code tool you are looking for doesn't exist or has been moved.</p>
    
    <div>
        <a href="{{ url('/') }}" class="btn btn-purple btn-lg" style="margin-right: 10px;">
            <span class="glyphicon glyphicon-home"></span> Go to Homepage
        </a>
        <a href="{{ url('/articles') }}" class="btn btn-default btn-lg" style="color: #5b287a; border-color: #5b287a;">
            Read Articles
        </a>
    </div>
</div>

<div class="article-section text-center" style="margin-top: 40px;">
    <h3>Looking to generate a QR Code?</h3>
    <p>Try one of our popular free tools:</p>
    <div style="margin-top: 20px;">
        <a href="{{ url('/qr-code-for-whatsapp') }}" style="display:inline-block; margin: 5px 15px; font-weight:bold;">QR Code for WhatsApp</a>
        <a href="{{ url('/qr-code-for-wifi') }}" style="display:inline-block; margin: 5px 15px; font-weight:bold;">QR Code for Wi-Fi</a>
        <a href="{{ url('/qr-code-with-logo') }}" style="display:inline-block; margin: 5px 15px; font-weight:bold;">QR Code with Logo</a>
    </div>
</div>
@endsection
