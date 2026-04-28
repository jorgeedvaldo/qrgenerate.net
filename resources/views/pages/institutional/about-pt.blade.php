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
        ['label' => 'Início', 'url' => url('/pt')],
        ['label' => 'Sobre Nós'],
    ]])

    <article class="article-section">
        <header style="margin-bottom:30px;">
            <h1>Sobre o QrGenerate</h1>
        </header>

        <div class="article-body">
            <p class="lead">O <strong>QrGenerate</strong> foi construído com uma missão simples: fornecer um gerador de QR Code rápido, privado e 100% gratuito que respeita o utilizador.</p>

            <div class="row" style="margin-top: 40px; margin-bottom: 40px;">
                <div class="col-md-4 text-center">
                    <span class="glyphicon glyphicon-flash" style="font-size: 40px; color: #7b4397; margin-bottom: 15px;"></span>
                    <h3 style="margin-top: 0;">Simplicidade</h3>
                    <p>Eliminámos a confusão. Sem formulários de registo, sem menus complexos e sem subscrições ocultas. Basta introduzir os seus dados e obter o QR Code instantaneamente.</p>
                </div>
                <div class="col-md-4 text-center">
                    <span class="glyphicon glyphicon-lock" style="font-size: 40px; color: #7b4397; margin-bottom: 15px;"></span>
                    <h3 style="margin-top: 0;">Privacidade em 1º Lugar</h3>
                    <p>Ao contrário de outros geradores que enviam os seus dados para servidores, o QrGenerate constrói o QR Code diretamente no seu navegador. Nós nunca vemos os seus dados.</p>
                </div>
                <div class="col-md-4 text-center">
                    <span class="glyphicon glyphicon-ok-circle" style="font-size: 40px; color: #7b4397; margin-bottom: 15px;"></span>
                    <h3 style="margin-top: 0;">Totalmente Grátis</h3>
                    <p>Geramos QR Codes estáticos que não expiram. Não há limites de digitalização e nunca colocamos a nossa marca d'água nos seus códigos.</p>
                </div>
            </div>

            <h3>A Nossa História</h3>
            <p>Reparámos que a maioria dos geradores de QR Code online atrai os utilizadores com ofertas "gratuitas", apenas para pedir um endereço de email ou cartão de crédito antes de descarregar a imagem final. Pior ainda, muitos destes serviços usam códigos dinâmicos por defeito, o que significa que os QR Codes deixam de funcionar se o utilizador não pagar uma subscrição mensal.</p>
            <p>Criámos o QrGenerate como alternativa. A nossa ferramenta gera QR Codes estáticos e permanentes usando tecnologias web modernas para processar tudo de forma segura no seu dispositivo. Quer precise de um simples link, um código de Wi-Fi ou um vCard para o seu negócio, o QrGenerate fornece-o de forma limpa e sem restrições.</p>

            <div class="jumbotron text-center" style="margin-top: 40px; padding: 30px;">
                <h2>Experimente você mesmo</h2>
                <p>Descubra a forma mais rápida de gerar um QR Code seguro.</p>
                <a href="{{ url('/pt') }}" class="btn btn-purple btn-lg">Gerar um QR Code Grátis</a>
            </div>
        </div>
    </article>
@endsection
