{{-- Article Page Template
     Used for static SEO articles and guides.
     Currently a placeholder — will be populated in a future phase.
--}}

@extends('layouts.app')

@section('content')

    {{-- Breadcrumb --}}
    @include('components.breadcrumb', ['items' => [
        ['label' => 'Home', 'url' => url('/')],
        ['label' => $article['title'] ?? 'Article'],
    ]])

    <div class="article-section">
        <h2>{{ $article['title'] ?? 'Article Title' }}</h2>

        @if(!empty($article['date']))
        <p style="color:#888; font-size:13px; margin-bottom:20px;">
            Published: {{ $article['date'] }} &middot; {{ config('qrgenerate.seo.author') }}
        </p>
        @endif

        {!! $article['content'] ?? '<p>Content coming soon.</p>' !!}
    </div>

@endsection
