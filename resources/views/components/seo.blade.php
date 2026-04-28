{{-- SEO Meta Tags Component
     Usage: @include('components.seo', ['seo' => [...]])
     All values are optional and fall back to config defaults.
--}}

@php
    $title       = $seo['title']          ?? config('qrgenerate.seo.title');
    $description = $seo['description']    ?? config('qrgenerate.seo.description');
    $keywords    = $seo['keywords']       ?? config('qrgenerate.seo.keywords');
    $canonical   = $seo['canonical']      ?? config('qrgenerate.url') . '/';
    $ogTitle     = $seo['og_title']       ?? $title;
    $ogDesc      = $seo['og_description'] ?? $description;
    $ogImage     = $seo['og_image']       ?? config('qrgenerate.url') . config('qrgenerate.seo.og_image');
    $ogType      = $seo['og_type']        ?? config('qrgenerate.seo.og_type');
    $twitterCard = $seo['twitter_card']   ?? config('qrgenerate.seo.twitter_card');
    $hreflang    = $seo['hreflang']       ?? [];
@endphp

<title>{{ $title }}</title>
<meta name="description" content="{{ $description }}">
@if(!empty($keywords))
<meta name="keywords" content="{{ $keywords }}">
@endif
<meta name="author" content="{{ config('qrgenerate.seo.author') }}">
<link rel="canonical" href="{{ $canonical }}">

{{-- Hreflang tags --}}
@foreach($hreflang as $lang => $url)
<link rel="alternate" hreflang="{{ $lang }}" href="{{ $url }}">
@endforeach

{{-- Open Graph --}}
<meta property="og:title" content="{{ $ogTitle }}">
<meta property="og:description" content="{{ $ogDesc }}">
<meta property="og:image" content="{{ $ogImage }}">
<meta property="og:url" content="{{ $canonical }}">
<meta property="og:type" content="{{ $ogType }}">
<meta property="og:site_name" content="{{ config('qrgenerate.name') }}">
@if(($locale ?? 'en') === 'pt')
<meta property="og:locale" content="pt_PT">
<meta property="og:locale:alternate" content="en_US">
@else
<meta property="og:locale" content="en_US">
<meta property="og:locale:alternate" content="pt_PT">
@endif

{{-- Twitter Card --}}
<meta name="twitter:card" content="{{ $twitterCard }}">
<meta name="twitter:title" content="{{ $ogTitle }}">
<meta name="twitter:description" content="{{ $ogDesc }}">
<meta name="twitter:image" content="{{ $ogImage }}">
