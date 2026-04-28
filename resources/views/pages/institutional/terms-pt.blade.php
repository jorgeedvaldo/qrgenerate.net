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
        ['label' => 'Termos de Uso'],
    ]])

    <article class="article-section">
        <header style="margin-bottom:30px;">
            <h1>Termos de Uso</h1>
            <p style="color:#888;font-size:14px;">
                Última atualização: {{ date('d \d\e F \d\e Y') }}
            </p>
        </header>

        <div class="article-body">
            <p>Bem-vindo ao <strong>QrGenerate</strong>. Ao aceder e utilizar este website, concorda em cumprir e ficar vinculado aos seguintes termos e condições de uso. Se não concordar com qualquer parte destes termos, por favor não utilize o nosso serviço.</p>

            <h3>1. Utilização Gratuita</h3>
            <p>O QrGenerate fornece um serviço de geração de QR Code gratuito e baseado no navegador. É livre de gerar um número ilimitado de QR Codes para uso pessoal ou comercial sem criar conta ou pagar quaisquer taxas.</p>

            <h3>2. Responsabilidade do Utilizador</h3>
            <p>O utilizador é o único responsável pelo conteúdo, URLs e dados que codifica nos QR Codes gerados neste site. O QrGenerate não verifica, aprova ou monitoriza os destinos dos QR Codes criados pelos utilizadores.</p>

            <h3>3. Usos Proibidos</h3>
            <p>Concorda em não usar o QrGenerate para criar QR Codes que liguem a ou contenham:</p>
            <ul>
                <li>Malware, sites de phishing ou vírus.</li>
                <li>Conteúdo ilegal, fraudulento ou prejudicial.</li>
                <li>Conteúdo que viole direitos de propriedade intelectual.</li>
            </ul>

            <h3>4. Disponibilidade do Serviço</h3>
            <p>Embora nos esforcemos por fornecer um serviço fiável, o QrGenerate é fornecido "tal como está" e "conforme disponível". Não garantimos tempo de atividade absoluto, acesso ininterrupto ou funcionamento sem erros. Reservamo-nos o direito de modificar, suspender ou descontinuar qualquer parte do serviço a qualquer momento sem aviso prévio.</p>

            <h3>5. Limitação de Responsabilidade</h3>
            <p>Em nenhum caso o QrGenerate, os seus proprietários ou programadores serão responsáveis por quaisquer danos diretos, indiretos, incidentais, consequenciais ou punitivos decorrentes da sua utilização ou incapacidade de utilizar o serviço. Isto inclui, mas não se limita a, danos por perda de lucros, dados ou outras perdas intangíveis resultantes do uso de QR Codes gerados.</p>

            <h3>6. Propriedade Intelectual</h3>
            <p>As imagens de QR Code geradas pertencem-lhe e podem ser usadas para qualquer fim comercial ou não comercial. No entanto, o design, código, marca e texto do próprio website QrGenerate estão protegidos por leis de propriedade intelectual e não podem ser copiados ou reproduzidos sem permissão.</p>

            <h3>7. Alterações aos Termos</h3>
            <p>Reservamo-nos o direito de atualizar estes Termos de Uso à nossa discrição. Encorajamo-lo a rever esta página periodicamente. A continuação do uso do serviço após quaisquer alterações constitui a sua aceitação dos novos termos.</p>
        </div>
    </article>
@endsection
