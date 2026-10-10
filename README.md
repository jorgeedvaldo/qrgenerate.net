# QRGenerate.net

> **Free QR Code Generator + Digital Menu for Restaurants** — no login, no fees, no data harvesting.

[![Laravel](https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)](https://php.net)
[![License: MIT](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)
[![GitHub repo](https://img.shields.io/badge/GitHub-qrgenerate.net-181717?logo=github)](https://github.com/jorgeedvaldo/qrgenerate.net)

**Live site → [qrgenerate.net](https://qrgenerate.net)**

---

## Table of Contents

- [Overview](#overview)
- [Features](#features)
- [Tech Stack](#tech-stack)
- [Getting Started](#getting-started)
- [Environment Variables](#environment-variables)
- [Running the Project](#running-the-project)
- [Project Structure](#project-structure)
- [Contributing](#contributing)
- [License](#license)
- [Português](#português)

---

## Overview

QRGenerate.net is an open-source web application that lets anyone create QR codes and digital menus for restaurants instantly — no account required.

**QR Code Generator:** Supports URLs, WhatsApp links, Wi-Fi credentials, plain text, vCards, and more. Generates high-resolution QR codes in SVG/PNG entirely in the browser — nothing is ever sent to a server.

**Digital Menu Generator:** Restaurant owners build a full menu (sections, items, prices, photos) and receive a permanent public URL + QR Code in seconds. An exclusive secret edit link lets them update the menu at any time without ever signing up.

---

## Features

### QR Code Generator
- 🔗 URL, WhatsApp, Wi-Fi, vCard, plain text, and more
- 🎨 Custom colors and embedded logo
- ⬇️ Download PNG or SVG
- 🖥️ 100% client-side — nothing sent to any server
- 🌐 Available in English and Portuguese

### Digital Menu for Restaurants
- 🍽️ Build a full restaurant menu with sections and items
- 📷 Drag-and-drop photo upload for logo, cover, and individual dishes
- 💰 Prices, descriptions, and dietary badges (vegan, vegetarian, gluten-free, spicy)
- 🔗 Generates a permanent public URL and QR Code instantly — no signup
- ✏️ Secret token-based edit link — update your menu anytime, no login ever needed
- 📧 Optional recovery email to retrieve the edit link if lost
- 🔍 Real-time search on the public menu page
- 🖨️ Print / Save as PDF or DOCX with a custom message on the printout
- 🎨 Customisable primary and accent colours per menu
- 📱 Fully responsive — looks great on any device

### Wedding & Engagement Invitations
- 💍 Online invitation page for a wedding or an engagement
- 👤 Free account with **Google sign-in** or just an email and password
- 💌 Personalised guest links — `?c=Name` greets the guest by name, or register a guest list and get one link each
- 📝 Online RSVP with companions, a note to the couple, and CSV export
- ⏳ Live countdown to the celebration
- 📍 Ceremony, reception and party, each with address, Google Maps button and an "add to calendar" button
- 🎁 Gift list with reservations (so nothing is brought twice), plus Pix key and bank details
- 📷 Photo gallery with a lightbox, and a guestbook for the guests' wishes
- 👗 Dress code, hashtag and optional background music
- 🎨 Four templates (classic, botanical, modern, romantic), four typefaces and custom colours
- 📱 Shareable link and a print-ready QR code

### SEO & Performance
- Bilingual routes (`/menu/create` ↔ `/cardapio/criar`, `/login` ↔ `/pt/entrar`, etc.)
- `hreflang` alternate links, canonical tags, and Schema.org JSON-LD
- Dynamic sitemap including all public menu pages and the invitation landing pages
- Invitation pages themselves are `noindex` — they belong to the couple's guests, not to search engines
- Open Graph meta tags for social sharing

---

## Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 12 (PHP 8.2) |
| Database | MySQL 8 / MariaDB 10.4+ (SQLite used for the test suite) |
| Frontend | Bootstrap 3.3.7 + Tailwind CSS 4 (Vite) |
| QR Generation | EasyQRCodeJS (client-side canvas) |
| Email | Laravel Mail (configurable SMTP / log driver) |
| File Storage | Laravel Storage (`public` disk + symlink) |
| Deployment | Any PHP 8.2+ host with MySQL |

---

## Getting Started

### Prerequisites

- PHP ≥ 8.2 with extensions: `pdo_mysql`, `pdo_sqlite` (tests), `mbstring`, `xml`, `curl`, `gd`
- MySQL ≥ 8.0 or MariaDB ≥ 10.4
- [Composer](https://getcomposer.org/) ≥ 2
- [Node.js](https://nodejs.org/) ≥ 18 + npm

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/jorgeedvaldo/qrgenerate.net.git
cd qrgenerate.net

# 2. Install PHP dependencies
composer install

# 3. Install JS dependencies and build assets
npm install && npm run build

# 4. Set up the environment
cp .env.example .env
php artisan key:generate

# 5. Create the database, then point .env at it (DB_DATABASE / DB_USERNAME / DB_PASSWORD)
mysql -u root -p -e "CREATE DATABASE qrgenerate CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 6. Run database migrations
php artisan migrate

# 7. Create the storage symlink (for uploaded images)
php artisan storage:link
```

---

## Environment Variables

Edit `.env` after copying `.env.example`. Key variables:

```env
APP_NAME=QRGenerate
APP_URL=https://qrgenerate.net       # Your public domain

# Database — MySQL / MariaDB
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=qrgenerate
DB_USERNAME=root
DB_PASSWORD=

# Google sign-in (optional — email/password still works without it).
# Create an OAuth 2.0 Client ID at https://console.cloud.google.com/apis/credentials
# and register ${APP_URL}/auth/google/callback as an authorised redirect URI.
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"

# Mail (required for menu link recovery and password resets)
MAIL_MAILER=smtp
MAIL_HOST=smtp.example.com
MAIL_PORT=587
MAIL_USERNAME=your@email.com
MAIL_PASSWORD=secret
MAIL_FROM_ADDRESS=noreply@qrgenerate.net
MAIL_FROM_NAME="QRGenerate"

# AdSense (optional)
ADSENSE_CLIENT=ca-pub-XXXXXXXXXXXXXXXX
ADSENSE_SLOT_MAIN=XXXXXXXXXX
```

> **Tip:** For local development, keep `MAIL_MAILER=log` — all emails are written to `storage/logs/laravel.log` instead of being sent.

---

## Running the Project

### Local Development

```bash
# Start the Laravel dev server
php artisan serve

# In a separate terminal, compile and watch assets
npm run dev
```

Visit [http://localhost:8000](http://localhost:8000).

### Production

```bash
npm run build
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Point your web server document root to the `public/` directory.

---

## Project Structure

```
app/
  Http/Controllers/
    MenuController.php             # Digital menu CRUD + email recovery
    QrPageController.php           # QR Code generator pages
    SitemapController.php          # Dynamic sitemap (includes public menus)
    InvitationController.php       # Invitation landing pages, owner CRUD, RSVP list + CSV
    InvitationGuestController.php  # Guest list and personalised links
    PublicInvitationController.php # Public invitation page, RSVP, guestbook, gift reservations
    Auth/                          # Register, login, logout, password reset, Google sign-in
  Http/Requests/
    InvitationRequest.php          # Validation shared by create and update
  Models/
    Menu.php                       # Menu (slug, edit token, email fields)
    MenuItem.php                   # Item (price, image_url, badges)
    MenuSection.php                # Section grouping items
    User.php                       # Account (nullable password for Google-only sign-in)
    Invitation.php                 # The invitation itself (couple, date, theme, settings)
    InvitationEvent.php            # Ceremony / reception / party, with map link
    InvitationGuest.php            # Named guest + their ?c= code
    InvitationRsvp.php             # A reply, with companions
    InvitationGift.php             # Gift list entry and its reservation
    InvitationPhoto.php            # Gallery photo
    InvitationMessage.php          # Guestbook note
  Support/
    AuthSeo.php                    # SEO metadata for the account pages
    InvitationLabels.php           # Bilingual form labels for the invitation builder
    HandlesImageUploads.php        # Upload-or-paste-a-URL image handling
  Mail/
    MenuLinkRecovery.php           # Mailable for lost edit-link recovery

database/migrations/        # All schema migrations (MySQL; also run on SQLite for tests)

resources/views/
  menu/
    create.blade.php        # Bilingual menu builder form (EN + PT)
    edit.blade.php          # Token-protected edit form
    show.blade.php          # Public menu page with live search
    success.blade.php       # Post-creation page: QR, print, PDF, DOCX
    recover.blade.php       # Edit-link recovery via email
    landing.blade.php       # SEO landing pages (EN + PT)
  invitations/
    landing.blade.php       # SEO landing pages (EN + PT)
    index.blade.php         # Owner dashboard listing their invitations
    create.blade.php        # New invitation
    edit.blade.php          # Edit an existing invitation
    _form.blade.php         # The 8-step builder, shared by create and edit
    _dash.blade.php         # Shared dashboard styling
    share.blade.php         # Public link + QR code + next steps
    guests.blade.php        # Guest list with one personalised link each
    rsvps.blade.php         # Replies, totals and CSV export
    show.blade.php          # The public invitation page (self-contained, themed)
  auth/
    login.blade.php
    register.blade.php
    forgot-password.blade.php
    reset-password.blade.php
  components/
    header.blade.php
    footer.blade.php

routes/web.php              # All routes (specific before catch-all slugs)
```

---

## Contributing

Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

1. Fork the repository
2. Create a feature branch: `git checkout -b feature/my-feature`
3. Commit your changes with a clear message
4. Push and open a Pull Request against `main`

---

## License

[MIT](LICENSE)

---

---

# Português

> **Gerador de QR Code + Cardápio Digital + Convites de Casamento e Noivado** — grátis e sem rastreamento de dados.

**Site ao vivo → [qrgenerate.net](https://qrgenerate.net)**

---

## Visão Geral

QRGenerate.net é uma aplicação web open-source que permite criar QR Codes e cardápios digitais para restaurantes instantaneamente — sem precisar de conta.

**Gerador de QR Code:** Suporta URLs, links WhatsApp, credenciais Wi-Fi, texto simples, vCards e mais. Gera QR Codes em alta resolução SVG/PNG direto no navegador — nada é enviado ao servidor.

**Gerador de Cardápio Digital:** Donos de restaurante montam o menu completo (seções, itens, preços, fotos) e recebem uma URL pública permanente + QR Code em segundos. Um link secreto de edição (baseado em token) permite atualizar o cardápio a qualquer momento, sem nunca criar uma conta.

**Convite de Casamento e Noivado:** Qualquer pessoa cria uma conta grátis (com o Google ou apenas com e-mail) e monta o convite virtual do seu casamento ou noivado — com link personalizado por convidado, confirmação de presença, contagem regressiva, mapa do local, lista de presentes, galeria de fotos, mural de recados e QR Code.

---

## Funcionalidades

### Gerador de QR Code
- 🔗 URL, WhatsApp, Wi-Fi, vCard, texto simples e mais
- 🎨 Cores personalizadas e logo embutido
- ⬇️ Download PNG ou SVG
- 🖥️ 100% no navegador — nenhum dado enviado ao servidor
- 🌐 Disponível em inglês e português

### Cardápio Digital para Restaurantes
- 🍽️ Monte um cardápio completo com seções e itens
- 📷 Upload de fotos (arrastar e soltar) para logo, capa e pratos individuais
- 💰 Preços, descrições e etiquetas dietéticas (vegano, vegetariano, sem glúten, picante)
- 🔗 Gera URL pública permanente e QR Code instantaneamente — sem cadastro
- ✏️ Link de edição secreto baseado em token — atualize seu cardápio a qualquer hora, sem login
- 📧 E-mail de recuperação opcional para resgatar o link de edição se perdido
- 🔍 Busca em tempo real na página pública do cardápio
- 🖨️ Imprimir / Salvar como PDF ou DOCX com mensagem personalizada na impressão
- 🎨 Cores primária e de destaque personalizáveis por cardápio
- 📱 Totalmente responsivo — ótimo em qualquer dispositivo

### Convite de Casamento e Noivado
- 💍 Página de convite online para casamento ou noivado
- 👤 Conta grátis com **login pelo Google** ou apenas e-mail e senha
- 💌 Link personalizado por convidado — `?c=Nome` saúda o convidado pelo nome, ou cadastre a lista e receba um link para cada um
- 📝 Confirmação de presença (RSVP) com acompanhantes, recado para o casal e exportação em CSV
- ⏳ Contagem regressiva em tempo real
- 📍 Cerimónia, recepção e festa, cada uma com endereço, botão do Google Maps e botão para adicionar à agenda
- 🎁 Lista de presentes com reserva (para ninguém repetir presente), além de chave Pix e dados bancários
- 📷 Galeria de fotos com visualização ampliada e mural de recados dos convidados
- 👗 Traje, hashtag e música de fundo opcional
- 🎨 Quatro estilos (clássico, botânico, moderno, romântico), quatro tipos de letra e cores personalizadas
- 📱 Link para partilhar e QR Code pronto a imprimir

---

## Instalação Rápida

```bash
git clone https://github.com/jorgeedvaldo/qrgenerate.net.git
cd qrgenerate.net
composer install
npm install && npm run build
cp .env.example .env
php artisan key:generate

# Crie a base de dados e aponte o .env para ela (DB_DATABASE / DB_USERNAME / DB_PASSWORD)
mysql -u root -p -e "CREATE DATABASE qrgenerate CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

php artisan migrate
php artisan storage:link
php artisan serve
```

Acesse [http://localhost:8000](http://localhost:8000).

---

## Variáveis de Ambiente

Edite o arquivo `.env` após copiar `.env.example`. Principais variáveis:

```env
APP_URL=https://qrgenerate.net

# Base de dados — MySQL / MariaDB
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=qrgenerate
DB_USERNAME=root
DB_PASSWORD=

# Login com Google (opcional — o login por e-mail e senha funciona sem isto).
# Crie um OAuth 2.0 Client ID em https://console.cloud.google.com/apis/credentials
# e registe ${APP_URL}/auth/google/callback como URI de redireccionamento autorizado.
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URI="${APP_URL}/auth/google/callback"

# E-mail (necessário para recuperação de link e redefinição de senha)
MAIL_MAILER=smtp
MAIL_HOST=smtp.seudominio.com
MAIL_PORT=587
MAIL_USERNAME=seu@email.com
MAIL_PASSWORD=senha
MAIL_FROM_ADDRESS=noreply@qrgenerate.net
MAIL_FROM_NAME="QRGenerate"
```

> **Dica:** Em desenvolvimento, mantenha `MAIL_MAILER=log` — os e-mails são gravados em `storage/logs/laravel.log` em vez de serem enviados.

---

## Contribuindo

Pull requests são bem-vindos. Para mudanças maiores, abra uma issue primeiro para discutir o que deseja mudar.

---

## Licença

[MIT](LICENSE)
