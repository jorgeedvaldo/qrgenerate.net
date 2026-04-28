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
        ['label' => 'Contact Us'],
    ]])

    <article class="article-section">
        <header style="margin-bottom:30px; text-center">
            <h1 class="text-center">Contact Us</h1>
            <p class="text-muted text-center" style="font-size:16px;">We would love to hear from you.</p>
        </header>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body" style="padding: 30px;">
                        <div class="text-center" style="margin-bottom: 30px;">
                            <span class="glyphicon glyphicon-envelope" style="font-size: 50px; color: #7b4397;"></span>
                            <h3 style="margin-top: 15px;">Get in Touch</h3>
                            <p>For support, business inquiries, or general questions, please send us an email at:</p>
                            <p style="font-size: 18px; margin-top: 15px;">
                                <a href="mailto:hello@qrgenerate.net" style="color: #5b287a; font-weight: bold;">hello@qrgenerate.net</a>
                            </p>
                        </div>
                        
                        <div class="tip-box">
                            <h4 style="margin-top: 0;"><span class="glyphicon glyphicon-info-sign"></span> Support Notice</h4>
                            <p style="margin-bottom: 0;">Because QrGenerate processes QR codes locally in your browser and we don't use user accounts, we cannot recover "lost" QR codes or manage billing (as the service is free). However, we welcome feature requests and bug reports!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection
