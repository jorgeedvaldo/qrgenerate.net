<?php

/*
|--------------------------------------------------------------------------
| QR Code SEO Pages — Português
|--------------------------------------------------------------------------
*/

return [

    'gerador-de-qr-code-gratis' => [
        'locale' => 'pt',
        'alternate_slug' => 'free-qr-code-generator',
        'title' => 'Gerador de QR Code Grátis Online — Sem Limites | QrGenerate',
        'meta_description' => 'Crie QR Codes grátis e ilimitados. Sem conta, sem marca d\'água. Gere QR Codes para URLs, texto, Wi-Fi e mais directamente no navegador.',
        'h1' => 'Gerador de QR Code Grátis',
        'intro' => 'Crie QR Codes de alta qualidade totalmente grátis. O QrGenerate funciona no seu navegador — os seus dados nunca saem do seu dispositivo. Sem conta, sem limites, sem marca d\'água.',
        'qr_type' => 'url',
        'use_cases' => [
            'Gere QR Codes para flyers, cartazes e cartões de visita.',
            'Crie códigos para embalagens e etiquetas de produtos.',
            'Partilhe credenciais Wi-Fi, contactos ou links de eventos.',
        ],
        'steps' => [
            'Introduza o seu URL ou texto no campo acima.',
            'Opcionalmente, carregue um logótipo e escolha cores personalizadas.',
            'Clique em "Generate QR Code" e descarregue o PNG.',
        ],
        'faqs' => [
            ['question' => 'O QrGenerate é mesmo grátis?', 'answer' => 'Sim, 100% grátis sem taxas escondidas. Não há limites de QR Codes e não é necessária conta.'],
            ['question' => 'Os meus QR Codes expiram?', 'answer' => 'Não. O QrGenerate cria QR Codes estáticos que codificam os dados directamente na imagem. Nunca expiram.'],
        ],
        'related_pages' => ['gerador-de-qr-code-sem-cadastro', 'gerador-de-qr-code-privado', 'qr-code-com-logotipo', 'qr-code-estatico-vs-dinamico', 'qr-code-para-whatsapp'],
    ],

    'gerador-de-qr-code-sem-cadastro' => [
        'locale' => 'pt',
        'alternate_slug' => 'free-qr-code-generator-no-signup',
        'title' => 'Gerador de QR Code Sem Cadastro — Sem Registo | QrGenerate',
        'meta_description' => 'Gere QR Codes instantaneamente sem criar conta. Sem cadastro, sem email. 100% no navegador e privado.',
        'h1' => 'Gerador de QR Code Sem Cadastro',
        'intro' => 'Esqueça formulários de registo. O QrGenerate permite criar QR Codes ilimitados sem se registar. Sem email, sem palavra-passe, sem dados pessoais recolhidos.',
        'qr_type' => 'url',
        'use_cases' => [
            'Gere rapidamente um QR Code para um evento pontual.',
            'Crie códigos em computadores partilhados sem deixar dados pessoais.',
            'Permita à equipa gerar QR Codes sem gerir contas de utilizador.',
        ],
        'steps' => [
            'Abra o QrGenerate — sem ecrã de login.',
            'Escreva ou cole o seu URL ou texto.',
            'Gere, descarregue e utilize o seu QR Code imediatamente.',
        ],
        'faqs' => [
            ['question' => 'Porque não exigem registo?', 'answer' => 'O QrGenerate gera QR Codes inteiramente no seu navegador. Como nenhum dado é enviado para um servidor, não há nada para associar a uma conta.'],
            ['question' => 'Posso personalizar o QR Code sem conta?', 'answer' => 'Claro. Pode mudar cores, adicionar logótipo e definir texto de impressão — tudo sem se registar.'],
        ],
        'related_pages' => ['gerador-de-qr-code-gratis', 'gerador-de-qr-code-privado', 'qr-code-estatico-vs-dinamico', 'qr-code-para-wifi', 'qr-code-para-cartao-de-visita'],
    ],

    'gerador-de-qr-code-privado' => [
        'locale' => 'pt',
        'alternate_slug' => 'private-qr-code-generator',
        'title' => 'Gerador de QR Code Privado — Os Seus Dados Ficam no Dispositivo | QrGenerate',
        'meta_description' => 'Gere QR Codes com total privacidade. O QrGenerate processa tudo no navegador — nenhum dado é carregado ou armazenado.',
        'h1' => 'Gerador de QR Code Privado',
        'intro' => 'A sua privacidade importa. O QrGenerate processa tudo localmente com JavaScript. Os seus URLs, textos, logótipos e imagens geradas nunca saem do seu dispositivo.',
        'qr_type' => 'url',
        'use_cases' => [
            'Gere QR Codes para documentos internos confidenciais.',
            'Crie códigos com passwords Wi-Fi sensíveis sem exposição.',
            'Produza QR Codes para URLs médicos ou jurídicos privados.',
        ],
        'steps' => [
            'Introduza o seu URL privado — fica no seu navegador.',
            'Adicione marca com logótipo se necessário.',
            'Descarregue o QR Code — nada é guardado nos nossos servidores.',
        ],
        'faqs' => [
            ['question' => 'Os meus dados são mesmo privados?', 'answer' => 'Sim. O QrGenerate usa JavaScript exclusivamente no lado do cliente. O seu conteúdo é processado no navegador e nunca transmitido.'],
            ['question' => 'Usam cookies ou rastreadores?', 'answer' => 'Usamos Google Analytics apenas para estatísticas de visitas. O conteúdo dos seus QR Codes nunca é rastreado ou armazenado.'],
        ],
        'related_pages' => ['gerador-de-qr-code-sem-cadastro', 'gerador-de-qr-code-gratis', 'qr-code-para-wifi', 'qr-code-para-email', 'qr-code-para-sms', 'qr-code-estatico-vs-dinamico'],
    ],

    'qr-code-estatico-vs-dinamico' => [
        'locale' => 'pt',
        'alternate_slug' => 'dynamic-qr-code-vs-static-qr-code',
        'title' => 'QR Code Estático vs Dinâmico — Diferenças Explicadas | QrGenerate',
        'meta_description' => 'Entenda a diferença entre QR Codes dinâmicos e estáticos. Saiba quando usar cada tipo e porque os estáticos oferecem melhor privacidade.',
        'h1' => 'QR Code Estático vs Dinâmico',
        'intro' => 'QR Codes estáticos são grátis, permanentes e privados — codificam os dados directamente na imagem. QR Codes dinâmicos usam um URL de redireccionamento que pode ser actualizado, mas dependem de um serviço externo.',
        'qr_type' => 'url',
        'use_cases' => [
            'Escolha estático para sinalética permanente, embalagens e cartões.',
            'Escolha dinâmico para campanhas onde o destino pode mudar.',
            'Use estático para conteúdo sensível como credenciais Wi-Fi.',
        ],
        'steps' => [
            'Decida se o seu URL de destino precisará de mudar.',
            'Se for permanente, use o QrGenerate para criar um código estático grátis.',
            'Se precisar de rastreamento ou mudanças, considere um serviço dinâmico pago.',
        ],
        'faqs' => [
            ['question' => 'Que tipo cria o QrGenerate?', 'answer' => 'O QrGenerate cria QR Codes estáticos. Os seus dados são codificados directamente na imagem sem dependência de servidor, sem expiração e sem custos.'],
            ['question' => 'Os QR Codes dinâmicos são melhores?', 'answer' => 'Não necessariamente. Oferecem flexibilidade mas requerem subscrição e dependem de servidor externo. Os estáticos são grátis, permanentes e privados.'],
        ],
        'related_pages' => ['gerador-de-qr-code-gratis', 'gerador-de-qr-code-privado', 'qr-code-para-cartao-de-visita', 'qr-code-com-logotipo'],
    ],

    'qr-code-para-whatsapp' => [
        'locale' => 'pt',
        'alternate_slug' => 'qr-code-for-whatsapp',
        'title' => 'QR Code para WhatsApp — Gere um Link de Chat | QrGenerate',
        'meta_description' => 'Crie um QR Code que abre uma conversa no WhatsApp com mensagem pré-preenchida. Grátis e instantâneo.',
        'h1' => 'QR Code para WhatsApp',
        'intro' => 'Gere um QR Code que abre uma conversa no WhatsApp instantaneamente. Use o formato <code>https://wa.me/NUMERO?text=MENSAGEM</code> para pré-preencher o destinatário e a mensagem.',
        'qr_type' => 'whatsapp',
        'use_cases' => [
            'Adicione um QR WhatsApp ao seu cartão de visita ou montra.',
            'Imprima um QR "Fale connosco" nas mesas do restaurante.',
            'Partilhe um link de encomenda pré-preenchido em eventos.',
        ],
        'steps' => [
            'Construa o link: https://wa.me/351912345678?text=Olá',
            'Cole o link no gerador acima.',
            'Gere e descarregue o seu QR Code.',
        ],
        'faqs' => [
            ['question' => 'Que formato devo usar?', 'answer' => 'Use <code>https://wa.me/INDICATIVO+NUMERO?text=SUA+MENSAGEM</code>. Substitua espaços por sinais +.'],
            ['question' => 'O destinatário precisa ter o meu número guardado?', 'answer' => 'Não. O link wa.me funciona mesmo que quem digitaliza não tenha o seu número nos contactos.'],
        ],
        'related_pages' => ['qr-code-para-sms', 'qr-code-para-email', 'qr-code-para-instagram', 'qr-code-para-cartao-de-visita', 'qr-code-com-logotipo'],
    ],

    'qr-code-para-wifi' => [
        'locale' => 'pt',
        'alternate_slug' => 'qr-code-for-wifi',
        'title' => 'QR Code para Wi-Fi — Partilhe a Sua Rede Instantaneamente | QrGenerate',
        'meta_description' => 'Crie um QR Code que liga smartphones à sua rede Wi-Fi automaticamente. Sem digitar passwords. Grátis e privado.',
        'h1' => 'QR Code para Wi-Fi',
        'intro' => 'Permita que os visitantes se liguem ao seu Wi-Fi com uma digitalização. Use o formato <code>WIFI:T:WPA;S:NomeDaRede;P:Password;;</code> para codificar as credenciais.',
        'qr_type' => 'wifi',
        'use_cases' => [
            'Exiba um QR Wi-Fi em quartos de hotel, cafés ou espaços de coworking.',
            'Imprima códigos de acesso Wi-Fi em guias de boas-vindas Airbnb.',
            'Partilhe Wi-Fi de casa com visitas sem ditar a password.',
        ],
        'steps' => [
            'Formate a string: WIFI:T:WPA;S:MinhaRede;P:MinhaPassword;;',
            'Cole no gerador acima.',
            'Imprima o QR Code e coloque perto do router ou entrada.',
        ],
        'faqs' => [
            ['question' => 'Que tipos de segurança são suportados?', 'answer' => 'Use <code>WPA</code> para WPA/WPA2/WPA3, <code>WEP</code> para WEP, ou vazio para redes abertas.'],
            ['question' => 'Funciona em iPhone e Android?', 'answer' => 'Sim. Tanto iOS (11+) como Android suportam QR Codes Wi-Fi nativamente através da câmara.'],
        ],
        'related_pages' => ['gerador-de-qr-code-privado', 'qr-code-para-localizacao', 'gerador-de-qr-code-gratis', 'qr-code-para-menu-de-restaurante', 'qr-code-com-logotipo'],
    ],

    'qr-code-com-logotipo' => [
        'locale' => 'pt',
        'alternate_slug' => 'qr-code-with-logo',
        'title' => 'QR Code com Logótipo — Adicione a Sua Marca | QrGenerate',
        'meta_description' => 'Gere QR Codes personalizados com o seu logótipo no centro. Grátis, alta qualidade e digitalizável.',
        'h1' => 'QR Code com Logótipo',
        'intro' => 'Torne os seus QR Codes reconhecíveis. Carregue o seu logótipo (PNG ou JPG) e o QrGenerate incorpora-o no centro do código. Usamos o Nível de Correcção de Erros H (30%) para manter a leitura mesmo com o logótipo.',
        'qr_type' => 'url',
        'use_cases' => [
            'Adicione marca aos QR Codes em materiais de marketing e menus.',
            'Coloque o logótipo da empresa em bilhetes e crachás de eventos.',
            'Crie QR Codes profissionais para apresentações a clientes.',
        ],
        'steps' => [
            'Introduza o URL ou conteúdo no campo.',
            'Clique em "Upload Logo" e seleccione a sua imagem.',
            'Gere o QR Code — o logótipo aparece centrado automaticamente.',
        ],
        'faqs' => [
            ['question' => 'O logótipo torna o QR Code ilegível?', 'answer' => 'Não. O QrGenerate usa o nível máximo de correcção de erros (H), que permite cobrir até 30% do código.'],
            ['question' => 'Que tamanho de logótipo funciona melhor?', 'answer' => 'Mantenha o logótipo abaixo de 25% da área do QR Code. Logótipos quadrados entre 60×60 e 80×80 pixels funcionam melhor.'],
        ],
        'related_pages' => ['gerador-de-qr-code-gratis', 'qr-code-para-cartao-de-visita', 'qr-code-para-instagram', 'qr-code-para-whatsapp', 'qr-code-para-menu-de-restaurante'],
    ],

    'qr-code-para-cartao-de-visita' => [
        'locale' => 'pt',
        'alternate_slug' => 'qr-code-for-business-card',
        'title' => 'QR Code para Cartão de Visita — Partilhe Contactos Instantaneamente | QrGenerate',
        'meta_description' => 'Crie um QR Code vCard para o seu cartão de visita. Uma digitalização guarda nome, telefone, email e website.',
        'h1' => 'QR Code para Cartão de Visita',
        'intro' => 'Adicione um QR Code ao seu cartão de visita que guarda os seus dados completos numa digitalização. Codifique um vCard com nome, telefone, email, empresa, cargo e website.',
        'qr_type' => 'vcard',
        'use_cases' => [
            'Imprima um QR Code vCard no verso do seu cartão de visita.',
            'Adicione um QR de contacto à sua assinatura de email.',
            'Exiba um QR Code de contacto em stands de feiras.',
        ],
        'steps' => [
            'Construa o seu vCard ou cole um URL de vCard.',
            'Introduza no gerador e adicione o logótipo da empresa.',
            'Descarregue e adicione ao design do seu cartão.',
        ],
        'faqs' => [
            ['question' => 'O que é o formato vCard?', 'answer' => 'Um vCard começa com BEGIN:VCARD e termina com END:VCARD. Contém campos como FN (nome), TEL (telefone), EMAIL, ORG (empresa), TITLE e URL.'],
            ['question' => 'Quantos dados cabem num QR Code vCard?', 'answer' => 'Um QR Code pode conter até ~4.000 caracteres. Um vCard típico usa 200-400, cabendo confortavelmente.'],
        ],
        'related_pages' => ['qr-code-para-email', 'qr-code-com-logotipo', 'qr-code-para-whatsapp', 'qr-code-para-localizacao', 'qr-code-para-instagram'],
    ],

    'qr-code-para-menu-de-restaurante' => [
        'locale' => 'pt',
        'alternate_slug' => 'qr-code-for-restaurant-menu',
        'title' => 'QR Code para Menu de Restaurante — Menus Digitais Sem Contacto | QrGenerate',
        'meta_description' => 'Gere um QR Code que liga ao menu digital do seu restaurante. Sem contacto, sempre actualizado e grátis.',
        'h1' => 'QR Code para Menu de Restaurante',
        'intro' => 'Substitua menus de papel por um QR Code digitalizável. Ligue ao menu digital alojado no seu site, Google Drive ou PDF. Actualize o menu a qualquer momento sem reimprimir QR Codes.',
        'qr_type' => 'url',
        'use_cases' => [
            'Coloque QR Codes em cada mesa para pedidos sem contacto.',
            'Adicione QR Codes de menu à montra ou sacos de takeaway.',
            'Imprima em porta-menus, bases de copos ou recibos.',
        ],
        'steps' => [
            'Carregue o menu como PDF ou crie uma página web.',
            'Cole o URL do menu no gerador acima.',
            'Imprima o QR Code em suportes de mesa ou autocolantes.',
        ],
        'faqs' => [
            ['question' => 'Posso actualizar o menu sem mudar o QR Code?', 'answer' => 'Sim — se mantiver o mesmo URL e actualizar o conteúdo (ex: substituir o PDF no mesmo link), o QR Code existente aponta sempre para a versão mais recente.'],
            ['question' => 'Qual o melhor formato para um menu digital?', 'answer' => 'Uma página web responsiva é ideal. Um PDF também funciona mas carrega mais lentamente nos telemóveis.'],
        ],
        'related_pages' => ['qr-code-para-wifi', 'qr-code-para-localizacao', 'gerador-de-qr-code-gratis', 'qr-code-para-pdf', 'qr-code-para-whatsapp'],
    ],

    'qr-code-para-instagram' => [
        'locale' => 'pt',
        'alternate_slug' => 'qr-code-for-instagram',
        'title' => 'QR Code para Instagram — Link para o Seu Perfil | QrGenerate',
        'meta_description' => 'Crie um QR Code que abre o seu perfil de Instagram directamente. Adicione a cartões, flyers ou embalagens.',
        'h1' => 'QR Code para Instagram',
        'intro' => 'Atraia seguidores para o seu perfil Instagram com um QR Code digitalizável. Introduza o URL do seu perfil (<code>https://instagram.com/seunome</code>) e gere um código de marca.',
        'qr_type' => 'url',
        'use_cases' => [
            'Adicione um QR Instagram a embalagens ou sacos de compras.',
            'Imprima QR Codes de perfil em cartões e banners de eventos.',
            'Exiba o QR Instagram no balcão ou recepção.',
        ],
        'steps' => [
            'Copie o URL do perfil: https://instagram.com/seunome',
            'Cole no gerador e carregue a foto de perfil como logótipo.',
            'Descarregue e use nos seus materiais de marketing.',
        ],
        'faqs' => [
            ['question' => 'Posso ligar a um post específico?', 'answer' => 'Sim. Cole o URL do post individual em vez do URL do perfil.'],
            ['question' => 'Devo usar o Nametag do Instagram?', 'answer' => 'Os Nametags do Instagram foram descontinuados. Um QR Code padrão com o URL do perfil é a abordagem recomendada.'],
        ],
        'related_pages' => ['qr-code-para-whatsapp', 'qr-code-com-logotipo', 'qr-code-para-cartao-de-visita', 'qr-code-para-menu-de-restaurante', 'gerador-de-qr-code-gratis'],
    ],

    'qr-code-para-pdf' => [
        'locale' => 'pt',
        'alternate_slug' => 'qr-code-for-pdf',
        'title' => 'QR Code para PDF — Link para Qualquer Documento | QrGenerate',
        'meta_description' => 'Gere um QR Code que abre um documento PDF. Partilhe menus, brochuras, manuais ou listas de preços com uma digitalização.',
        'h1' => 'QR Code para PDF',
        'intro' => 'Partilhe qualquer documento PDF via QR Code. Carregue o PDF num serviço de alojamento (Google Drive, Dropbox ou o seu site) e cole o link directo no QrGenerate.',
        'qr_type' => 'url',
        'use_cases' => [
            'Ligue brochuras impressas à versão PDF digital completa.',
            'Partilhe manuais de instruções em embalagens de produtos.',
            'Distribua programas de eventos ou listas de preços.',
        ],
        'steps' => [
            'Carregue o PDF no Google Drive, Dropbox ou no seu site.',
            'Obtenha o link de partilha público e cole no gerador.',
            'Gere e imprima o QR Code junto do material impresso.',
        ],
        'faqs' => [
            ['question' => 'Onde devo alojar o meu PDF?', 'answer' => 'O Google Drive (com partilha "Qualquer pessoa com o link") é grátis e fiável. O seu próprio site oferece carregamento mais rápido.'],
            ['question' => 'Posso actualizar o PDF sem mudar o QR Code?', 'answer' => 'Sim — se substituir o ficheiro no mesmo URL, o QR Code aponta sempre para a versão mais recente.'],
        ],
        'related_pages' => ['qr-code-para-menu-de-restaurante', 'gerador-de-qr-code-gratis', 'qr-code-com-logotipo', 'qr-code-para-wifi', 'qr-code-estatico-vs-dinamico'],
    ],

    'qr-code-para-localizacao' => [
        'locale' => 'pt',
        'alternate_slug' => 'qr-code-for-location',
        'title' => 'QR Code para Localização — Abra o Google Maps Instantaneamente | QrGenerate',
        'meta_description' => 'Crie um QR Code que abre uma localização específica no Google Maps. Perfeito para convites, cartões e sinalética.',
        'h1' => 'QR Code para Localização',
        'intro' => 'Ajude as pessoas a encontrá-lo. Crie um QR Code que abre uma localização precisa no Google Maps. Use um link de partilha do Google Maps ou coordenadas no formato <code>geo:LAT,LNG</code>.',
        'qr_type' => 'location',
        'use_cases' => [
            'Adicione um QR de localização a convites de casamento ou eventos.',
            'Imprima direcções em cartões de visita ou papel timbrado.',
            'Exiba um QR "Encontre-nos" na montra da loja.',
        ],
        'steps' => [
            'Abra o Google Maps, encontre a localização e clique em "Partilhar".',
            'Cole o link do Google Maps no gerador acima.',
            'Descarregue o QR Code e adicione ao convite ou sinalética.',
        ],
        'faqs' => [
            ['question' => 'Que formato de link devo usar?', 'answer' => 'O mais simples é um link de partilha do Google Maps. Também pode usar o formato geo: URI para compatibilidade multiplataforma.'],
            ['question' => 'Funciona com Apple Maps?', 'answer' => 'Um link Google Maps abre no Google Maps em Android e oferece abrir no Apple Maps em iPhone.'],
        ],
        'related_pages' => ['qr-code-para-menu-de-restaurante', 'qr-code-para-cartao-de-visita', 'qr-code-para-whatsapp', 'qr-code-para-wifi', 'qr-code-para-instagram'],
    ],

    'qr-code-para-email' => [
        'locale' => 'pt',
        'alternate_slug' => 'qr-code-for-email',
        'title' => 'QR Code para Email — Pré-Preencha Endereço, Assunto e Corpo | QrGenerate',
        'meta_description' => 'Gere um QR Code que abre um email pré-preenchido. Defina destinatário, assunto e texto automaticamente.',
        'h1' => 'QR Code para Email',
        'intro' => 'Facilite o contacto por email. Crie um QR Code com o formato <code>mailto:</code> que pré-preenche endereço, assunto e corpo da mensagem. Uma digitalização abre o email pronto a enviar.',
        'qr_type' => 'email',
        'use_cases' => [
            'Adicione um QR "Contacte-nos" a materiais de marketing impressos.',
            'Pré-preencha emails de feedback em embalagens de produtos.',
            'Inclua um QR de email rápido em crachás de conferências.',
        ],
        'steps' => [
            'Construa o link: mailto:voce@exemplo.com?subject=Olá&body=Mensagem',
            'Cole no gerador acima.',
            'Descarregue e imprima o QR Code de email.',
        ],
        'faqs' => [
            ['question' => 'Qual é o formato mailto?', 'answer' => 'Use <code>mailto:email@exemplo.com?subject=Seu+Assunto&body=Sua+Mensagem</code>. Substitua espaços por +.'],
            ['question' => 'Funciona em todos os telemóveis?', 'answer' => 'Sim. O protocolo mailto: é suportado por todos os smartphones modernos e abre a app de email predefinida.'],
        ],
        'related_pages' => ['qr-code-para-sms', 'qr-code-para-whatsapp', 'qr-code-para-cartao-de-visita', 'gerador-de-qr-code-privado', 'qr-code-para-instagram'],
    ],

    'qr-code-para-sms' => [
        'locale' => 'pt',
        'alternate_slug' => 'qr-code-for-sms',
        'title' => 'QR Code para SMS — Pré-Preencha uma Mensagem de Texto | QrGenerate',
        'meta_description' => 'Crie um QR Code que abre uma mensagem SMS pré-preenchida. Defina número e texto automaticamente.',
        'h1' => 'QR Code para SMS',
        'intro' => 'Gere um QR Code que abre a app de mensagens com número e texto pré-preenchidos. Use o formato <code>sms:+351912345678?body=Sua+Mensagem</code>.',
        'qr_type' => 'sms',
        'use_cases' => [
            'Crie QR Codes de opt-in para campanhas de SMS marketing.',
            'Adicione um QR "Envie-nos uma mensagem" a cartões ou montras.',
            'Pré-preencha pedidos de suporte em etiquetas de produtos.',
        ],
        'steps' => [
            'Construa o link SMS: sms:+351912345678?body=Olá',
            'Cole no gerador acima.',
            'Gere e descarregue o seu QR Code para SMS.',
        ],
        'faqs' => [
            ['question' => 'Que formato SMS funciona melhor?', 'answer' => 'Use <code>sms:+INDICATIVONUMERO?body=Mensagem</code> para iOS e Android modernos.'],
            ['question' => 'O SMS é enviado automaticamente?', 'answer' => 'Não. Por razões de segurança, digitalizar o QR Code apenas pré-preenche a mensagem. O utilizador deve tocar em "Enviar" manualmente.'],
        ],
        'related_pages' => ['qr-code-para-whatsapp', 'qr-code-para-email', 'gerador-de-qr-code-gratis', 'qr-code-para-cartao-de-visita', 'qr-code-para-instagram'],
    ],

];
