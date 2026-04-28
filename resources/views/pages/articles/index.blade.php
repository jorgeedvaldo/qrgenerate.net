@extends('layouts.app')

@section('content')

    @include('components.breadcrumb', ['items' => [
        ['label' => ($locale ?? 'en') === 'pt' ? 'Início' : 'Home', 'url' => ($locale ?? 'en') === 'pt' ? url('/pt') : url('/')],
        ['label' => ($locale ?? 'en') === 'pt' ? 'Artigos' : 'Articles'],
    ]])

    <div class="jumbotron text-center">
        <h1>{{ ($locale ?? 'en') === 'pt' ? 'Artigos e Guias sobre QR Code' : 'QR Code Articles & Guides' }}</h1>
        <p>{{ ($locale ?? 'en') === 'pt' ? 'Aprenda tudo sobre QR Codes: como criar, boas práticas e casos de uso.' : 'Learn everything about QR codes: how to create them, best practices, and use cases.' }}</p>
    </div>

    @if(empty($articles))
        <div class="article-section text-center">
            <p class="lead text-muted">
                {{ ($locale ?? 'en') === 'pt' ? 'Ainda não há artigos publicados.' : 'No articles published yet.' }}
            </p>
        </div>
    @else
        <div class="row">
            @foreach($articles as $article)
                <div class="col-md-6" style="margin-bottom:25px;">
                    <div class="panel panel-purple">
                        <div class="panel-heading">
                            <span class="label label-default pull-right">{{ $article['category'] }}</span>
                            <small>{{ \Carbon\Carbon::parse($article['date'])->format('M d, Y') }}</small>
                        </div>
                        <div class="panel-body">
                            <h3 style="margin-top:0;">
                                <a href="{{ ($locale ?? 'en') === 'pt' ? url('/pt/artigos/' . $article['slug']) : url('/articles/' . $article['slug']) }}">
                                    {{ $article['title'] }}
                                </a>
                            </h3>
                            <p style="color:#666;">{{ Str::limit($article['description'], 150) }}</p>
                            @if(!empty($article['tags']))
                                <p>
                                    @foreach($article['tags'] as $tag)
                                        <span class="label" style="background:#7b4397;margin-right:4px;">{{ $tag }}</span>
                                    @endforeach
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif

@endsection
