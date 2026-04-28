@extends('layouts.app')

@push('schema')
@php
$articleSchema = [
    '@context' => 'https://schema.org',
    '@type' => 'Article',
    'headline' => $article['title'],
    'description' => $article['description'],
    'datePublished' => $article['date'],
    'dateModified' => $article['updated_at'] ?? $article['date'],
    'author' => ['@type' => 'Organization', 'name' => config('qrgenerate.seo.author')],
    'publisher' => [
        '@type' => 'Organization',
        'name' => config('qrgenerate.name'),
        'logo' => ['@type' => 'ImageObject', 'url' => config('qrgenerate.url') . '/images/logo.png'],
    ],
    'mainEntityOfPage' => [
        '@type' => 'WebPage',
        '@id' => $seo['canonical'],
    ],
    'inLanguage' => $article['locale'],
];
if (!empty($article['cover'])) {
    $articleSchema['image'] = [config('qrgenerate.url') . $article['cover']];
}
@endphp
<script type="application/ld+json">{!! json_encode($articleSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush

@section('content')

    @include('components.breadcrumb', ['items' => [
        ['label' => ($locale ?? 'en') === 'pt' ? 'Início' : 'Home', 'url' => ($locale ?? 'en') === 'pt' ? url('/pt') : url('/')],
        ['label' => ($locale ?? 'en') === 'pt' ? 'Artigos' : 'Articles', 'url' => ($locale ?? 'en') === 'pt' ? url('/pt/artigos') : url('/articles')],
        ['label' => $article['title']],
    ]])

    <article class="article-section">
        {{-- Header --}}
        <header style="margin-bottom:30px;">
            <h1>{{ $article['title'] }}</h1>
            <p style="color:#888;font-size:14px;">
                <span class="glyphicon glyphicon-calendar"></span>
                {{ \Carbon\Carbon::parse($article['date'])->format('F d, Y') }}
                @if(!empty($article['category']))
                    &middot; <span class="label" style="background:#7b4397;">{{ $article['category'] }}</span>
                @endif
            </p>
            @if(!empty($article['tags']))
                <p>
                    @foreach($article['tags'] as $tag)
                        <span class="label label-default" style="margin-right:4px;">{{ $tag }}</span>
                    @endforeach
                </p>
            @endif
        </header>

        {{-- Table of Contents --}}
        @if(!empty($article['toc']) && count($article['toc']) >= 3)
        <div class="tip-box" style="margin-bottom:30px;">
            <p><strong>{{ ($locale ?? 'en') === 'pt' ? 'Índice' : 'Table of Contents' }}</strong></p>
            <ul style="margin-top:8px;margin-bottom:0;">
                @foreach($article['toc'] as $item)
                    <li style="margin-left:{{ ($item['level'] - 2) * 20 }}px; margin-bottom:4px;">
                        <a href="#{{ $item['id'] }}">{{ $item['text'] }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- Article Body --}}
        <div class="article-body">
            {!! $article['body'] !!}
        </div>
    </article>

    {{-- Related Articles --}}
    @if(!empty($related))
    <div class="article-section">
        <h2>{{ ($locale ?? 'en') === 'pt' ? 'Artigos relacionados' : 'Related Articles' }}</h2>
        <ul>
            @foreach($related as $rel)
                <li>
                    <a href="{{ ($locale ?? 'en') === 'pt' ? url('/pt/artigos/' . $rel['slug']) : url('/articles/' . $rel['slug']) }}">
                        {{ $rel['title'] }}
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- CTA --}}
    <div class="jumbotron text-center" style="margin-top:30px;">
        <h2>{{ ($locale ?? 'en') === 'pt' ? 'Pronto para criar o seu QR Code?' : 'Ready to Create Your QR Code?' }}</h2>
        <a href="{{ ($locale ?? 'en') === 'pt' ? url('/pt') : url('/') }}" class="btn btn-purple btn-lg">
            {{ ($locale ?? 'en') === 'pt' ? 'Criar QR Code Agora' : 'Create QR Code Now' }}
        </a>
    </div>

@endsection
