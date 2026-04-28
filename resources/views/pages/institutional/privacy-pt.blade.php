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
        ['label' => 'Política de Privacidade'],
    ]])

    <article class="article-section">
        <header style="margin-bottom:30px;">
            <h1>Política de Privacidade</h1>
            <p style="color:#888;font-size:14px;">
                Última atualização: {{ date('d \d\e F \d\e Y') }}
            </p>
        </header>

        <div class="article-body">
            <p>No <strong>QrGenerate</strong>, a sua privacidade é a nossa principal prioridade. Acreditamos que as ferramentas online devem ser seguras, transparentes e respeitar os seus dados. Esta Política de Privacidade explica como lidamos com a informação quando utiliza o nosso gerador de QR Code gratuito.</p>

            <h3>1. Processamento Local no Seu Navegador</h3>
            <p>A funcionalidade principal do QrGenerate — a geração de QR Codes — acontece inteiramente no seu dispositivo (client-side) usando JavaScript. <strong>Nós não carregamos, transmitimos ou armazenamos o conteúdo dos seus QR Codes nos nossos servidores.</strong> Os seus URLs, textos, credenciais Wi-Fi, dados vCard e logótipos carregados permanecem estritamente dentro do seu navegador durante o processo de geração.</p>

            <h3>2. Sem Necessidade de Conta</h3>
            <p>Não precisa de criar uma conta, iniciar sessão ou fornecer um endereço de email para utilizar o QrGenerate. Não recolhemos informações pessoalmente identificáveis (PII) para fornecer o nosso serviço principal.</p>

            <h3>3. Logs Técnicos de Servidor</h3>
            <p>Como a maioria dos websites, os nossos servidores de alojamento registam automaticamente logs técnicos básicos quando visita o QrGenerate. Estes logs podem incluir o seu endereço IP, tipo de navegador, página de referência e carimbo de data/hora. Estes logs são usados exclusivamente para fins de segurança, prevenção de abusos e monitorização do desempenho do servidor, sendo purgados regularmente.</p>

            <h3>4. Analytics e Ferramentas de Terceiros</h3>
            <p>Para entender como as pessoas utilizam o nosso website e melhorar o nosso serviço, podemos utilizar ferramentas básicas de análise (como o Google Analytics). Estas ferramentas recolhem dados agregados e anonimizados sobre visualizações de páginas e interações. Elas não têm acesso ao conteúdo que digita no gerador de QR Code.</p>
            <div class="tip-box">
                <p><em>[Nota: Se adicionar o Google Analytics ou outros rastreadores, configure a política de cookies aqui.]</em></p>
            </div>

            <h3>5. Cookies</h3>
            <p>Utilizamos apenas os cookies essenciais necessários para o funcionamento básico do website. Se integrações de terceiros forem utilizadas, estas podem definir os seus próprios cookies de acordo com as suas políticas de privacidade.</p>

            <h3>6. Alterações a Esta Política</h3>
            <p>Podemos atualizar esta Política de Privacidade ocasionalmente. Quaisquer alterações serão publicadas nesta página com uma data de revisão atualizada.</p>

            <h3>7. Contacte-nos</h3>
            <p>Se tiver alguma questão ou preocupação relativamente à sua privacidade enquanto utiliza o QrGenerate, não hesite em <a href="{{ url('/pt/contacto') }}">contactar-nos</a>.</p>
        </div>
    </article>
@endsection
