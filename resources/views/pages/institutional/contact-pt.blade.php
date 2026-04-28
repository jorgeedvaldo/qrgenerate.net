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
        ['label' => 'Contacto'],
    ]])

    <article class="article-section">
        <header style="margin-bottom:30px; text-center">
            <h1 class="text-center">Contacte-nos</h1>
            <p class="text-muted text-center" style="font-size:16px;">Gostaríamos muito de ouvir a sua opinião.</p>
        </header>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-body" style="padding: 30px;">
                        <div class="text-center" style="margin-bottom: 30px;">
                            <span class="glyphicon glyphicon-envelope" style="font-size: 50px; color: #7b4397;"></span>
                            <h3 style="margin-top: 15px;">Fale Connosco</h3>
                            <p>Para suporte, questões comerciais ou dúvidas gerais, por favor envie-nos um email para:</p>
                            <p style="font-size: 18px; margin-top: 15px;">
                                <a href="mailto:hello@qrgenerate.net" style="color: #5b287a; font-weight: bold;">hello@qrgenerate.net</a>
                            </p>
                        </div>
                        
                        <div class="tip-box">
                            <h4 style="margin-top: 0;"><span class="glyphicon glyphicon-info-sign"></span> Aviso de Suporte</h4>
                            <p style="margin-bottom: 0;">Como o QrGenerate processa os QR Codes localmente no seu navegador e não usamos contas de utilizador, não podemos recuperar QR Codes "perdidos" ou gerir faturação (já que o serviço é grátis). No entanto, agradecemos muito sugestões de funcionalidades e relatórios de bugs!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </article>
@endsection
