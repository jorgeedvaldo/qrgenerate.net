@extends('layouts.app')

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebPage",
  "name": "Server Error",
  "description": "An unexpected error occurred."
}
</script>
@endpush

@section('content')
<div class="jumbotron text-center" style="margin-top: 50px; padding: 60px 20px; background-image: linear-gradient(to bottom, #a65353 0%, #883434 100%);">
    <h1 style="font-size: 80px; margin-bottom: 20px;">500</h1>
    <h2>Internal Server Error</h2>
    <p style="margin-bottom: 30px;">Oops! Something went wrong on our end while processing your request.</p>
    
    <div>
        <a href="{{ url('/') }}" class="btn btn-default btn-lg" style="color: #883434; font-weight:bold;">
            <span class="glyphicon glyphicon-home"></span> Return to Homepage
        </a>
    </div>
</div>

<div class="article-section text-center" style="margin-top: 40px;">
    <h3>What happened?</h3>
    <p>We've been notified of the issue and are looking into it. Please try again in a few minutes.</p>
    <p>If you need immediate assistance, you can <a href="{{ url('/contact') }}">contact support</a>.</p>
</div>
@endsection
