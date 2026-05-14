@extends('layouts.app')

@php
$lang = $menuLocale ?? 'pt';
$isPt = ($lang === 'pt');

$t = [
    'pt' => [
        'hero_title'    => 'Crie o Cardápio Digital do seu Restaurante',
        'hero_sub'      => 'Gratuito · Sem cadastro · Gera QR Code automaticamente',
        'step1'         => 'Informações do Restaurante',
        'step1_badge'   => 'Passo 1',
        'step2'         => 'Seções e Itens do Cardápio',
        'step2_badge'   => 'Passo 2',
        'step2_hint'    => 'Organize seu cardápio em seções (ex: Entradas, Pizzas, Bebidas) e adicione os itens de cada seção.',
        'name_label'    => 'Nome do Restaurante',
        'desc_label'    => 'Descrição / Slogan',
        'desc_ph'       => 'Ex: A melhor pizza da cidade desde 1995',
        'phone_label'   => 'Telefone',
        'phone_ph'      => '(11) 99999-9999',
        'wa_label'      => 'WhatsApp (número com DDD)',
        'wa_ph'         => '5511999999999',
        'wa_hint'       => 'Botão direto de contato no cardápio',
        'addr_label'    => 'Endereço',
        'addr_ph'       => 'Rua das Flores, 123 – São Paulo, SP',
        'ig_label'      => 'Instagram (apenas @usuario)',
        'ig_ph'         => '@restaurante',
        'web_label'     => 'Website',
        'logo_label'    => 'URL da Logo (imagem)',
        'cover_label'   => 'URL da Foto de Capa',
        'url_hint'      => 'Cole o link de uma imagem hospedada online',
        'colors_label'  => 'Cores do Cardápio',
        'color1_label'  => 'Cor Principal',
        'color2_label'  => 'Cor de Destaque',
        'preview_label' => 'Prévia',
        'preview_hint'  => 'Aparência no cardápio público',
        'section_ph'    => 'Nome da seção (ex: Pizzas)',
        'sec_desc_ph'   => 'Descrição da seção (opcional)',
        'item_name_label'=> 'Nome do Item',
        'item_name_ph'  => 'Ex: Pizza Margherita',
        'price_label'   => 'Preço (R$)',
        'item_desc_label'=> 'Descrição',
        'item_desc_ph'  => 'Ingredientes, modo de preparo...',
        'item_img_label'=> 'Foto do Item (URL)',
        'available_lbl' => 'Disponível',
        'featured_lbl'  => '⭐ Destaque',
        'badges_lbl'    => 'Etiquetas',
        'add_item'      => '+ Adicionar Item',
        'add_section'   => '+ Adicionar Seção',
        'submit'        => '🚀 Gerar Cardápio e QR Code',
        'submit_hint'   => 'Você receberá um link exclusivo para editar o cardápio depois',
        'error_title'   => 'Por favor corrija os erros abaixo:',
        'section_err'   => 'Cada seção precisa ter pelo menos um item.',
        'section_min'   => 'O cardápio precisa ter pelo menos uma seção.',
        'vegan'         => '🌿 Vegano',
        'veggie'        => '🥗 Vegetariano',
        'gluten'        => '🌾 Sem Glúten',
        'spicy'         => '🌶️ Picante',
        'lang_switch'   => '🇬🇧 See in English',
        'lang_switch_url'=> route('menu.create.en'),
        'required'      => ' *',
    ],
    'en' => [
        'hero_title'    => 'Create Your Restaurant\'s Digital Menu',
        'hero_sub'      => 'Free · No Signup · Generates QR Code Automatically',
        'step1'         => 'Restaurant Information',
        'step1_badge'   => 'Step 1',
        'step2'         => 'Sections & Menu Items',
        'step2_badge'   => 'Step 2',
        'step2_hint'    => 'Organise your menu into sections (e.g. Starters, Mains, Drinks) and add the items for each section.',
        'name_label'    => 'Restaurant Name',
        'desc_label'    => 'Description / Tagline',
        'desc_ph'       => 'e.g. The best pizza in town since 1995',
        'phone_label'   => 'Phone',
        'phone_ph'      => '+1 555-000-0000',
        'wa_label'      => 'WhatsApp (number with country code)',
        'wa_ph'         => '15550000000',
        'wa_hint'       => 'Direct contact button on the menu page',
        'addr_label'    => 'Address',
        'addr_ph'       => '123 Flower St – New York, NY',
        'ig_label'      => 'Instagram (handle only)',
        'ig_ph'         => '@myrestaurant',
        'web_label'     => 'Website',
        'logo_label'    => 'Logo URL (image)',
        'cover_label'   => 'Cover Photo URL',
        'url_hint'      => 'Paste a link to an image hosted online',
        'colors_label'  => 'Menu Colours',
        'color1_label'  => 'Primary Colour',
        'color2_label'  => 'Accent Colour',
        'preview_label' => 'Preview',
        'preview_hint'  => 'How it appears on the public menu',
        'section_ph'    => 'Section name (e.g. Pizzas)',
        'sec_desc_ph'   => 'Section description (optional)',
        'item_name_label'=> 'Item Name',
        'item_name_ph'  => 'e.g. Margherita Pizza',
        'price_label'   => 'Price',
        'item_desc_label'=> 'Description',
        'item_desc_ph'  => 'Ingredients, preparation notes...',
        'item_img_label'=> 'Item Photo (URL)',
        'available_lbl' => 'Available',
        'featured_lbl'  => '⭐ Featured',
        'badges_lbl'    => 'Labels',
        'add_item'      => '+ Add Item',
        'add_section'   => '+ Add Section',
        'submit'        => '🚀 Generate Menu & QR Code',
        'submit_hint'   => 'You\'ll receive an exclusive link to edit the menu afterwards',
        'error_title'   => 'Please fix the errors below:',
        'section_err'   => 'Each section must have at least one item.',
        'section_min'   => 'The menu must have at least one section.',
        'vegan'         => '🌿 Vegan',
        'veggie'        => '🥗 Vegetarian',
        'gluten'        => '🌾 Gluten-Free',
        'spicy'         => '🌶️ Spicy',
        'lang_switch'   => '🇧🇷 Ver em Português',
        'lang_switch_url'=> route('menu.create.pt'),
        'required'      => ' *',
    ],
];
$i = $t[$lang];
@endphp

@push('schema')
<script type="application/ld+json">
{
  "@@context": "https://schema.org",
  "@@type": "WebApplication",
  "name": "{{ $isPt ? 'Gerador de Cardápio Digital' : 'Digital Menu Generator' }}",
  "url": "{{ $isPt ? route('menu.create.pt') : route('menu.create.en') }}",
  "applicationCategory": "BusinessApplication",
  "operatingSystem": "Web",
  "offers": { "@@type": "Offer", "price": "0", "priceCurrency": "BRL" },
  "description": "{{ $isPt ? 'Crie cardápio digital para restaurante com QR Code. Grátis e sem cadastro.' : 'Create a digital menu for your restaurant with QR Code. Free and no signup.' }}"
}
</script>
@endpush

@push('styles')
<style>
    .menu-builder { max-width: 860px; margin: 0 auto; padding: 24px 0 60px; }
    .lang-switch { text-align: right; margin-bottom: 12px; }
    .lang-switch a { font-size: 13px; color: #7b4397; text-decoration: none; border: 1px solid #d1bfe0; border-radius: 6px; padding: 4px 10px; }
    .lang-switch a:hover { background: #f3edf7; }
    .builder-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,.08); margin-bottom: 20px; overflow: hidden; }
    .builder-card-header { background: linear-gradient(135deg, #7b4397, #5b287a); color: #fff; padding: 14px 20px; font-size: 15px; font-weight: 600; display: flex; align-items: center; gap: 8px; }
    .builder-card-body { padding: 20px; }
    .form-group label { font-weight: 600; color: #444; margin-bottom: 4px; display: block; font-size: 13px; }
    .form-control { border-radius: 8px !important; border: 1.5px solid #ddd !important; transition: border-color .2s; font-size: 14px; }
    .form-control:focus { border-color: #7b4397 !important; box-shadow: 0 0 0 3px rgba(123,67,151,.12) !important; outline: none; }
    .section-card { background: #faf8fc; border: 1.5px solid #e4d9f0; border-radius: 10px; margin-bottom: 16px; overflow: hidden; }
    .section-header { background: linear-gradient(135deg, #f3edf7, #e8dcf2); padding: 12px 16px; display: flex; align-items: center; gap: 10px; border-bottom: 1px solid #e4d9f0; }
    .section-header input { flex: 1; border: none; background: transparent; font-weight: 700; color: #5b287a; font-size: 15px; outline: none; }
    .section-header input::placeholder { color: #b49dcc; }
    .section-body { padding: 14px; }
    .item-card { background: #fff; border: 1.5px solid #e8e8e8; border-radius: 8px; padding: 14px; margin-bottom: 10px; position: relative; }
    .item-card:hover { border-color: #c4a8e0; }
    .item-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    .badge-selector { display: flex; flex-wrap: wrap; gap: 6px; margin-top: 6px; }
    .badge-chip { display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; border-radius: 99px; font-size: 12px; font-weight: 600; cursor: pointer; border: 1.5px solid transparent; transition: all .15s; user-select: none; }
    .badge-chip input { display: none; }
    .badge-chip.vegan   { border-color: #22c55e; color: #15803d; background: #f0fdf4; }
    .badge-chip.vegan.active   { background: #22c55e; color: #fff; }
    .badge-chip.veggie  { border-color: #84cc16; color: #3f6212; background: #f7fee7; }
    .badge-chip.veggie.active  { background: #84cc16; color: #fff; }
    .badge-chip.gluten  { border-color: #f59e0b; color: #92400e; background: #fffbeb; }
    .badge-chip.gluten.active  { background: #f59e0b; color: #fff; }
    .badge-chip.spicy   { border-color: #ef4444; color: #991b1b; background: #fef2f2; }
    .badge-chip.spicy.active   { background: #ef4444; color: #fff; }
    .toggle-group { display: flex; align-items: center; gap: 8px; }
    .toggle-label { font-size: 12px; color: #666; font-weight: 600; }
    .toggle { position: relative; width: 36px; height: 20px; }
    .toggle input { opacity: 0; width: 0; height: 0; }
    .toggle-slider { position: absolute; inset: 0; background: #ccc; border-radius: 99px; cursor: pointer; transition: .2s; }
    .toggle-slider::before { content: ''; position: absolute; height: 14px; width: 14px; left: 3px; bottom: 3px; background: white; border-radius: 50%; transition: .2s; }
    .toggle input:checked + .toggle-slider { background: #7b4397; }
    .toggle input:checked + .toggle-slider::before { transform: translateX(16px); }
    .btn-add-item { width: 100%; border: 2px dashed #c4a8e0; background: transparent; color: #7b4397; border-radius: 8px; padding: 8px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all .15s; }
    .btn-add-item:hover { background: #f3edf7; border-color: #7b4397; }
    .btn-add-section { width: 100%; border: 2px dashed #7b4397; background: transparent; color: #7b4397; border-radius: 10px; padding: 12px; font-size: 14px; font-weight: 700; cursor: pointer; transition: all .15s; margin-top: 4px; }
    .btn-add-section:hover { background: #f3edf7; }
    .btn-remove { background: none; border: none; color: #ccc; cursor: pointer; padding: 2px 6px; border-radius: 4px; font-size: 16px; transition: color .15s; }
    .btn-remove:hover { color: #ef4444; }
    .color-row { display: flex; gap: 16px; align-items: flex-end; flex-wrap: wrap; }
    .color-field { display: flex; flex-direction: column; gap: 4px; }
    .color-preview-input { width: 38px; height: 38px; border-radius: 8px; border: 2px solid #ddd; cursor: pointer; }
    .preview-bar { height: 8px; border-radius: 99px; margin-top: 8px; transition: background .3s; }
    .step-badge { background: rgba(255,255,255,.25); border-radius: 6px; padding: 2px 8px; font-size: 12px; margin-left: auto; }
    .submit-btn { background: linear-gradient(135deg, #7b4397, #5b287a); color: #fff; border: none; border-radius: 10px; padding: 14px 36px; font-size: 16px; font-weight: 700; cursor: pointer; transition: opacity .2s; width: 100%; }
    .submit-btn:hover { opacity: .9; }
    .field-hint { font-size: 11px; color: #999; margin-top: 2px; }
    @media(max-width:600px){ .item-row { grid-template-columns: 1fr; } .color-row { gap: 10px; } }
</style>
@endpush

@section('content')
<div class="menu-builder">

    {{-- Language switcher --}}
    <div class="lang-switch">
        <a href="{{ $i['lang_switch_url'] }}">{{ $i['lang_switch'] }}</a>
    </div>

    {{-- Hero --}}
    <div style="text-align:center; padding: 10px 0 30px;">
        <div style="font-size:48px; margin-bottom:10px;">🍽️</div>
        <h1 style="font-size:28px; font-weight:800; color:#5b287a; margin:0 0 8px;">{{ $i['hero_title'] }}</h1>
        <p style="color:#777; font-size:15px; margin:0;">{{ $i['hero_sub'] }}</p>
    </div>

    <form action="{{ route('menu.store') }}" method="POST" id="menuForm">
        @csrf

        @if($errors->any())
        <div class="alert alert-danger" style="border-radius:10px;">
            <strong>{{ $i['error_title'] }}</strong>
            <ul style="margin:8px 0 0; padding-left:18px;">
                @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
        @endif

        {{-- Step 1: Restaurant Info --}}
        <div class="builder-card">
            <div class="builder-card-header">
                🏪 {{ $i['step1'] }}
                <span class="step-badge">{{ $i['step1_badge'] }}</span>
            </div>
            <div class="builder-card-body">
                <div class="form-group" style="margin-bottom:14px;">
                    <label>{{ $i['name_label'] }}{{ $i['required'] }}</label>
                    <input type="text" name="restaurant_name" class="form-control" placeholder="{{ $isPt ? 'Ex: Pizzaria do Marco' : 'e.g. Marco\'s Pizzeria' }}" value="{{ old('restaurant_name') }}" required maxlength="100">
                </div>
                <div class="form-group" style="margin-bottom:14px;">
                    <label>{{ $i['desc_label'] }}</label>
                    <textarea name="description" class="form-control" rows="2" placeholder="{{ $i['desc_ph'] }}" maxlength="500">{{ old('description') }}</textarea>
                </div>
                <div class="item-row" style="margin-bottom:14px;">
                    <div class="form-group">
                        <label>{{ $i['phone_label'] }}</label>
                        <input type="text" name="phone" class="form-control" placeholder="{{ $i['phone_ph'] }}" value="{{ old('phone') }}" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label>{{ $i['wa_label'] }}</label>
                        <input type="text" name="whatsapp" class="form-control" placeholder="{{ $i['wa_ph'] }}" value="{{ old('whatsapp') }}" maxlength="30">
                        <div class="field-hint">{{ $i['wa_hint'] }}</div>
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:14px;">
                    <label>{{ $i['addr_label'] }}</label>
                    <input type="text" name="address" class="form-control" placeholder="{{ $i['addr_ph'] }}" value="{{ old('address') }}" maxlength="200">
                </div>
                <div class="item-row" style="margin-bottom:14px;">
                    <div class="form-group">
                        <label>{{ $i['ig_label'] }}</label>
                        <input type="text" name="instagram" class="form-control" placeholder="{{ $i['ig_ph'] }}" value="{{ old('instagram') }}" maxlength="100">
                    </div>
                    <div class="form-group">
                        <label>{{ $i['web_label'] }}</label>
                        <input type="url" name="website" class="form-control" placeholder="https://..." value="{{ old('website') }}" maxlength="200">
                    </div>
                </div>
                <div class="item-row" style="margin-bottom:14px;">
                    <div class="form-group">
                        <label>{{ $i['logo_label'] }}</label>
                        <input type="url" name="logo_url" class="form-control" placeholder="https://..." value="{{ old('logo_url') }}" maxlength="500">
                        <div class="field-hint">{{ $i['url_hint'] }}</div>
                    </div>
                    <div class="form-group">
                        <label>{{ $i['cover_label'] }}</label>
                        <input type="url" name="cover_url" class="form-control" placeholder="https://..." value="{{ old('cover_url') }}" maxlength="500">
                    </div>
                </div>
                <div style="margin-top:4px;">
                    <label style="font-weight:600; color:#444; font-size:13px; display:block; margin-bottom:8px;">{{ $i['colors_label'] }}</label>
                    <div class="color-row">
                        <div class="color-field">
                            <label style="font-size:12px; color:#666;">{{ $i['color1_label'] }}</label>
                            <input type="color" id="primary_color" name="primary_color" value="{{ old('primary_color', '#d97706') }}" class="color-preview-input">
                        </div>
                        <div class="color-field">
                            <label style="font-size:12px; color:#666;">{{ $i['color2_label'] }}</label>
                            <input type="color" id="accent_color" name="accent_color" value="{{ old('accent_color', '#92400e') }}" class="color-preview-input">
                        </div>
                        <div style="flex:1; min-width:160px;">
                            <label style="font-size:12px; color:#666;">{{ $i['preview_label'] }}</label>
                            <div id="colorPreview" class="preview-bar"></div>
                            <div style="font-size:11px; color:#999; margin-top:4px;">{{ $i['preview_hint'] }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Step 2: Sections & Items --}}
        <div class="builder-card">
            <div class="builder-card-header">
                📋 {{ $i['step2'] }}
                <span class="step-badge">{{ $i['step2_badge'] }}</span>
            </div>
            <div class="builder-card-body">
                <p style="color:#888; font-size:13px; margin-bottom:16px;">{{ $i['step2_hint'] }}</p>
                <div id="sectionsContainer">
                    <div class="section-card" data-section="0">
                        <div class="section-header">
                            <span style="font-size:16px;">📂</span>
                            <input type="text" name="sections[0][name]" placeholder="{{ $i['section_ph'] }}" maxlength="100" required>
                            <button type="button" class="btn-remove" onclick="removeSection(this)">✕</button>
                        </div>
                        <div class="section-body">
                            <input type="text" name="sections[0][description]" class="form-control" placeholder="{{ $i['sec_desc_ph'] }}" style="margin-bottom:12px;" maxlength="300">
                            <div class="items-container"></div>
                            <button type="button" class="btn-add-item" onclick="addItem(this)">{{ $i['add_item'] }}</button>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-add-section" onclick="addSection()">{{ $i['add_section'] }}</button>
            </div>
        </div>

        <button type="submit" class="submit-btn">{{ $i['submit'] }}</button>
        <p style="text-align:center; color:#999; font-size:12px; margin-top:10px;">{{ $i['submit_hint'] }}</p>
    </form>
</div>

{{-- Item template (hidden) --}}
<template id="itemTemplate">
    <div class="item-card">
        <div class="item-row" style="margin-bottom:10px;">
            <div class="form-group">
                <label>{{ $i['item_name_label'] }}{{ $i['required'] }}</label>
                <input type="text" name="__NAME__" class="form-control" placeholder="{{ $i['item_name_ph'] }}" maxlength="150" required>
            </div>
            <div class="form-group">
                <label>{{ $i['price_label'] }}</label>
                <input type="number" name="__PRICE__" class="form-control" placeholder="0.00" step="0.01" min="0">
            </div>
        </div>
        <div class="form-group" style="margin-bottom:10px;">
            <label>{{ $i['item_desc_label'] }}</label>
            <input type="text" name="__DESC__" class="form-control" placeholder="{{ $i['item_desc_ph'] }}" maxlength="400">
        </div>
        <div class="form-group" style="margin-bottom:10px;">
            <label>{{ $i['item_img_label'] }}</label>
            <input type="url" name="__IMG__" class="form-control" placeholder="https://..." maxlength="500">
        </div>
        <div style="display:flex; flex-wrap:wrap; gap:16px; align-items:center; margin-bottom:8px;">
            <div class="toggle-group">
                <span class="toggle-label">{{ $i['available_lbl'] }}</span>
                <label class="toggle">
                    <input type="checkbox" name="__AVAIL__" value="1" checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="toggle-group">
                <span class="toggle-label">{{ $i['featured_lbl'] }}</span>
                <label class="toggle">
                    <input type="checkbox" name="__FEAT__" value="1">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div style="flex:1;">
                <div style="font-size:12px; color:#666; font-weight:600; margin-bottom:4px;">{{ $i['badges_lbl'] }}</div>
                <div class="badge-selector">
                    <label class="badge-chip vegan" onclick="toggleBadge(this)">
                        <input type="checkbox" name="__BADGES__" value="vegan"> {{ $i['vegan'] }}
                    </label>
                    <label class="badge-chip veggie" onclick="toggleBadge(this)">
                        <input type="checkbox" name="__BADGES__" value="vegetariano"> {{ $i['veggie'] }}
                    </label>
                    <label class="badge-chip gluten" onclick="toggleBadge(this)">
                        <input type="checkbox" name="__BADGES__" value="sem_gluten"> {{ $i['gluten'] }}
                    </label>
                    <label class="badge-chip spicy" onclick="toggleBadge(this)">
                        <input type="checkbox" name="__BADGES__" value="picante"> {{ $i['spicy'] }}
                    </label>
                </div>
            </div>
        </div>
        <button type="button" class="btn-remove" style="position:absolute; top:10px; right:10px;" onclick="removeItem(this)">✕</button>
    </div>
</template>
@endsection

@push('scripts')
<script>
const SECTION_ERR  = @json($i['section_err']);
const SECTION_MIN  = @json($i['section_min']);
let sectionCount = 1;

function updateColorPreview() {
    const p = document.getElementById('primary_color').value;
    const a = document.getElementById('accent_color').value;
    document.getElementById('colorPreview').style.background = `linear-gradient(to right, ${p}, ${a})`;
}
document.getElementById('primary_color').addEventListener('input', updateColorPreview);
document.getElementById('accent_color').addEventListener('input', updateColorPreview);
updateColorPreview();

function addSection() {
    const idx = sectionCount++;
    const container = document.getElementById('sectionsContainer');
    const div = document.createElement('div');
    div.className = 'section-card';
    div.dataset.section = idx;
    div.innerHTML = `
        <div class="section-header">
            <span style="font-size:16px;">📂</span>
            <input type="text" name="sections[${idx}][name]" placeholder="{{ $i['section_ph'] }}" maxlength="100" required>
            <button type="button" class="btn-remove" onclick="removeSection(this)">✕</button>
        </div>
        <div class="section-body">
            <input type="text" name="sections[${idx}][description]" class="form-control" placeholder="{{ $i['sec_desc_ph'] }}" style="margin-bottom:12px;" maxlength="300">
            <div class="items-container"></div>
            <button type="button" class="btn-add-item" onclick="addItem(this)">{{ $i['add_item'] }}</button>
        </div>`;
    container.appendChild(div);
    div.querySelector('input').focus();
}

function removeSection(btn) {
    const section = btn.closest('.section-card');
    if (document.querySelectorAll('.section-card').length <= 1) {
        alert(SECTION_MIN);
        return;
    }
    section.remove();
    reindexSections();
}

function reindexSections() {
    document.querySelectorAll('.section-card').forEach((sec, si) => {
        sec.dataset.section = si;
        sec.querySelectorAll('[name]').forEach(el => {
            el.name = el.name.replace(/sections\[\d+\]/, `sections[${si}]`);
        });
        reindexItems(sec, si);
    });
}

function addItem(btn) {
    const sectionCard = btn.closest('.section-card');
    const si = parseInt(sectionCard.dataset.section);
    const container = sectionCard.querySelector('.items-container');
    const ii = container.querySelectorAll('.item-card').length;

    const tpl = document.getElementById('itemTemplate').content.cloneNode(true);
    const div = tpl.querySelector('.item-card');
    div.innerHTML = div.innerHTML
        .replace(/__NAME__/g,  `sections[${si}][items][${ii}][name]`)
        .replace(/__PRICE__/g, `sections[${si}][items][${ii}][price]`)
        .replace(/__DESC__/g,  `sections[${si}][items][${ii}][description]`)
        .replace(/__IMG__/g,   `sections[${si}][items][${ii}][image_url]`)
        .replace(/__AVAIL__/g, `sections[${si}][items][${ii}][is_available]`)
        .replace(/__FEAT__/g,  `sections[${si}][items][${ii}][is_featured]`)
        .replace(/__BADGES__/g,`sections[${si}][items][${ii}][badges][]`);
    container.appendChild(div);
    div.querySelector('input').focus();
}

function removeItem(btn) {
    const item = btn.closest('.item-card');
    const sectionCard = item.closest('.section-card');
    item.remove();
    reindexItems(sectionCard, parseInt(sectionCard.dataset.section));
}

function reindexItems(sectionCard, si) {
    sectionCard.querySelectorAll('.item-card').forEach((item, ii) => {
        item.querySelectorAll('[name]').forEach(el => {
            el.name = el.name.replace(/sections\[\d+\]\[items\]\[\d+\]/, `sections[${si}][items][${ii}]`);
        });
    });
}

function toggleBadge(label) {
    const cb = label.querySelector('input[type=checkbox]');
    setTimeout(() => label.classList.toggle('active', cb.checked), 0);
}

document.getElementById('menuForm').addEventListener('submit', function(e) {
    let valid = true;
    document.querySelectorAll('.section-card').forEach(sec => {
        if (sec.querySelectorAll('.item-card').length === 0) {
            valid = false;
            sec.querySelector('.section-header input').style.borderBottom = '2px solid #ef4444';
        }
    });
    if (!valid) { e.preventDefault(); alert(SECTION_ERR); }
});
</script>
@endpush
