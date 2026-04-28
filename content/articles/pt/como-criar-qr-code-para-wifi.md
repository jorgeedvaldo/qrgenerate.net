---
title: "Como Criar QR Code para Wi-Fi"
slug: "como-criar-qr-code-para-wifi"
locale: "pt"
description: "Crie um QR Code que liga smartphones à sua rede Wi-Fi automaticamente. Aprenda o formato correcto e boas práticas para hotéis, cafés e escritórios."
date: "2024-09-10"
updated_at: "2024-10-01"
category: "Tutoriais"
tags: ["wifi", "qr code", "rede", "hotelaria"]
alternate_slug: "how-to-create-a-qr-code-for-wifi"
---

## Porquê Usar um QR Code para Wi-Fi?

Partilhar a password do Wi-Fi oralmente é inconveniente e propenso a erros. Um QR Code Wi-Fi permite que os visitantes se liguem à sua rede com uma única digitalização — sem digitar nada. Tanto iOS (11+) como Android suportam esta funcionalidade nativamente.

## O Formato do QR Code Wi-Fi

O formato padrão é:

```
WIFI:T:WPA;S:NomeDaRede;P:SuaPassword;;
```

### Parâmetros

| Parâmetro | Descrição | Valores |
|-----------|-----------|--------|
| `T` | Tipo de segurança | `WPA`, `WEP`, ou vazio para rede aberta |
| `S` | Nome da rede (SSID) | O nome do seu Wi-Fi |
| `P` | Password | A password do Wi-Fi |
| `H` | Rede oculta | `true` se oculta |

## Passo a Passo

1. Encontre o nome da rede (SSID) e a password.
2. Construa a string usando o formato acima.
3. Cole no [QrGenerate.net](https://qrgenerate.net/pt).
4. Gere o QR Code e descarregue.
5. Imprima e exiba perto do router ou entrada.

## Onde Exibir QR Codes Wi-Fi

- **Hotéis:** Cartões de boas-vindas ou mesas de cabeceira.
- **Restaurantes e cafés:** Porta-menus, mesas ou cartazes na parede.
- **Escritórios:** Salas de reunião, recepção ou espaços de coworking.
- **Airbnb:** Guias de boas-vindas ou ímanes de frigorífico.

## Dica de Segurança

Altere a password do Wi-Fi periodicamente e regenere o QR Code. Para redes de convidados, considere criar um SSID separado com largura de banda limitada.
