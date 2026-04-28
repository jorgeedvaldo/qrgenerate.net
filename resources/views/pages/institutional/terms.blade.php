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
        ['label' => 'Terms of Use'],
    ]])

    <article class="article-section">
        <header style="margin-bottom:30px;">
            <h1>Terms of Use</h1>
            <p style="color:#888;font-size:14px;">
                Last updated: {{ date('F d, Y') }}
            </p>
        </header>

        <div class="article-body">
            <p>Welcome to <strong>QrGenerate</strong>. By accessing and using this website, you agree to comply with and be bound by the following terms and conditions of use. If you disagree with any part of these terms, please do not use our service.</p>

            <h3>1. Free Usage</h3>
            <p>QrGenerate provides a free, browser-based QR code generation service. You are free to generate an unlimited number of QR codes for personal or commercial use without creating an account or paying any fees.</p>

            <h3>2. User Responsibility</h3>
            <p>You are solely responsible for the content, URLs, and data you encode into the QR codes generated on this site. QrGenerate does not verify, endorse, or monitor the destinations of the QR codes created by users.</p>

            <h3>3. Prohibited Uses</h3>
            <p>You agree not to use QrGenerate to create QR codes that link to or contain:</p>
            <ul>
                <li>Malware, phishing sites, or viruses.</li>
                <li>Illegal, fraudulent, or harmful content.</li>
                <li>Content that violates intellectual property rights.</li>
            </ul>

            <h3>4. Service Availability</h3>
            <p>While we strive to provide a reliable service, QrGenerate is provided on an "as is" and "as available" basis. We do not guarantee absolute uptime, uninterrupted access, or error-free operation. We reserve the right to modify, suspend, or discontinue any part of the service at any time without notice.</p>

            <h3>5. Limitation of Liability</h3>
            <p>In no event shall QrGenerate, its owners, or its developers be liable for any direct, indirect, incidental, consequential, or punitive damages arising out of your use of or inability to use the service. This includes, but is not limited to, damages for loss of profits, data, or other intangible losses resulting from the use of generated QR codes.</p>

            <h3>6. Intellectual Property</h3>
            <p>The generated QR code images belong to you and can be used for any commercial or non-commercial purpose. However, the design, code, branding, and text of the QrGenerate website itself are protected by intellectual property laws and may not be copied or reproduced without permission.</p>

            <h3>7. Changes to Terms</h3>
            <p>We reserve the right to update these Terms of Use at our discretion. We encourage you to review this page periodically. Continued use of the service after any changes constitutes your acceptance of the new terms.</p>
        </div>
    </article>
@endsection
