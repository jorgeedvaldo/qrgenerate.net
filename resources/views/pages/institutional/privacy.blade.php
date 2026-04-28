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
        ['label' => 'Privacy Policy'],
    ]])

    <article class="article-section">
        <header style="margin-bottom:30px;">
            <h1>Privacy Policy</h1>
            <p style="color:#888;font-size:14px;">
                Last updated: {{ date('F d, Y') }}
            </p>
        </header>

        <div class="article-body">
            <p>At <strong>QrGenerate</strong>, your privacy is our top priority. We believe that tools should be secure, transparent, and respectful of your data. This Privacy Policy explains how we handle information when you use our free QR code generator.</p>

            <h3>1. Local Processing in Your Browser</h3>
            <p>The core feature of QrGenerate — the generation of QR codes — happens entirely on your device (client-side) using JavaScript. <strong>We do not upload, transmit, or store the content of your QR codes on our servers.</strong> Your URLs, text, Wi-Fi credentials, vCard data, and uploaded logos stay strictly within your browser during the generation process.</p>

            <h3>2. No Account Required</h3>
            <p>You do not need to create an account, sign in, or provide an email address to use QrGenerate. We do not collect personally identifiable information (PII) to deliver our core service.</p>

            <h3>3. Technical Server Logs</h3>
            <p>Like most websites, our hosting servers automatically record basic technical logs when you visit QrGenerate. These logs may include your IP address, browser type, referring page, and timestamp. These logs are used solely for security purposes, preventing abuse, and monitoring server performance, and they are regularly purged.</p>

            <h3>4. Analytics and Third-Party Tools</h3>
            <p>To understand how people use our website and to improve our service, we may use basic analytics tools (such as Google Analytics). These tools collect aggregated, anonymised data about page views and interactions. They do not have access to the content you type into the QR code generator.</p>
            <div class="tip-box">
                <p><em>[Note: If you add Google Analytics or other trackers, ensure you mention cookie usage here. If no analytics are used, this section can be simplified.]</em></p>
            </div>

            <h3>5. Cookies</h3>
            <p>We only use essential cookies necessary for the basic functioning of the website. If third-party analytics are integrated, they may set their own cookies in accordance with their privacy policies.</p>

            <h3>6. Changes to This Policy</h3>
            <p>We may update this Privacy Policy occasionally. Any changes will be posted on this page with an updated revision date.</p>

            <h3>7. Contact Us</h3>
            <p>If you have any questions or concerns regarding your privacy while using QrGenerate, please feel free to <a href="{{ url('/contact') }}">contact us</a>.</p>
        </div>
    </article>
@endsection
