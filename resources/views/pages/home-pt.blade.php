@extends('layouts.app')

@push('schema')
@php
$schemaData = [
    '@context' => 'https://schema.org',
    '@type' => 'WebApplication',
    'name' => config('qrgenerate.name'),
    'url' => config('qrgenerate.url') . '/pt',
    'applicationCategory' => 'UtilityApplication',
    'operatingSystem' => 'Any',
    'inLanguage' => 'pt',
    'offers' => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD'],
];
@endphp
<script type="application/ld+json">{!! json_encode($schemaData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}</script>
@endpush

@section('content')

    {{-- Hero --}}
    <div class="jumbotron text-center">
        <h1>Crie o Seu QR Code Personalizado</h1>
        <p>100% Grátis. Sem servidores. Máxima privacidade. Gere QR Codes de alta qualidade directamente no seu navegador.</p>
    </div>

    {{-- QR Code Generator --}}
    @include('components.qr-generator')

    {{-- Tipos de QR Code --}}
    <div class="article-section">
        <h2>Tipos de QR Code Disponíveis</h2>
        <div class="row">
            @php
            $ptPages = config('qr_pages_pt');
            $featured = ['qr-code-para-whatsapp', 'qr-code-para-wifi', 'qr-code-com-logotipo', 'qr-code-para-cartao-de-visita', 'qr-code-para-menu-de-restaurante', 'qr-code-para-instagram'];
            @endphp
            @foreach($featured as $slug)
                @if(isset($ptPages[$slug]))
                <div class="col-md-4 col-sm-6" style="margin-bottom:20px;">
                    <div class="panel panel-purple">
                        <div class="panel-body">
                            <h4><a href="{{ url('/pt/' . $slug) }}">{{ $ptPages[$slug]['h1'] }}</a></h4>
                            <p style="font-size:14px;color:#666;">{{ Str::limit($ptPages[$slug]['intro'], 100) }}</p>
                        </div>
                    </div>
                </div>
                @endif
            @endforeach
        </div>
    </div>

    {{-- Artigo resumido --}}
    <div class="article-section">
        <h2>O Guia Completo dos QR Codes</h2>
        <p class="lead">Os QR Codes evoluíram de simples etiquetas de inventário para uma das ferramentas digitais mais versáteis do marketing moderno, saúde, logística e vida quotidiana.</p>

        <h3>O que é um QR Code?</h3>
        <p>Um QR Code (Quick Response) é um código de barras bidimensional inventado em 1994 pela Denso Wave, no Japão. Ao contrário dos códigos de barras tradicionais, um QR Code usa uma matriz de quadrados que permite armazenar até 7.089 caracteres numéricos num formato visual compacto.</p>

        <h3>Porquê usar o QrGenerate?</h3>
        <p>O QrGenerate é um gerador 100% no navegador — sem instalação, sem conta, sem dados enviados para qualquer servidor. O seu logótipo é lido localmente e incorporado directamente no canvas do QR Code. O resultado é um PNG de alta resolução que pode descarregar, imprimir ou incorporar como HTML.</p>

        <div class="tip-box">
            <p><strong>Sabia que?</strong> O QrGenerate usa o Nível de Correcção de Erros H por defeito, o que significa que o QR Code continua legível mesmo que quase um terço esteja coberto — perfeito para colocar logótipos no centro.</p>
        </div>

        <p style="margin-top:24px; color:#888; font-size:13px;">Última actualização: Setembro 2024 &middot; QrGenerate &middot; Todos os QR Codes são gerados localmente no seu navegador. Nenhum dado é armazenado ou transmitido.</p>
    </div>

@endsection
