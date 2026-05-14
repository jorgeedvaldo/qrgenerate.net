@extends('layouts.app')

@push('styles')
<style>
    .menu-builder { max-width: 860px; margin: 0 auto; padding: 24px 0 60px; }
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
    .color-preview { width: 38px; height: 38px; border-radius: 8px; border: 2px solid #ddd; cursor: pointer; }
    .preview-bar { height: 8px; border-radius: 99px; margin-top: 8px; transition: background .3s; }
    .step-badge { background: rgba(255,255,255,.25); border-radius: 6px; padding: 2px 8px; font-size: 12px; margin-left: auto; }
    .submit-btn { background: linear-gradient(135deg, #7b4397, #5b287a); color: #fff; border: none; border-radius: 10px; padding: 14px 36px; font-size: 16px; font-weight: 700; cursor: pointer; transition: opacity .2s; width: 100%; }
    .submit-btn:hover { opacity: .9; }
    .field-hint { font-size: 11px; color: #999; margin-top: 2px; }
    @media(max-width:600px){ .item-row { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div class="menu-builder">

    <div style="text-align:center; padding: 20px 0 30px;">
        <div style="font-size:40px; margin-bottom:10px;">✏️</div>
        <h1 style="font-size:26px; font-weight:800; color:#5b287a; margin:0 0 6px;">Editar Cardápio</h1>
        <p style="color:#777; font-size:14px; margin:0;">{{ $menu->restaurant_name }}</p>
    </div>

    @if(session('success'))
    <div class="alert alert-success" style="border-radius:10px;">{{ session('success') }}</div>
    @endif

    @if($errors->any())
    <div class="alert alert-danger" style="border-radius:10px;">
        <strong>Por favor corrija os erros:</strong>
        <ul style="margin:8px 0 0; padding-left:18px;">
            @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('menu.update', $menu->slug) }}" method="POST" id="menuForm">
        @csrf
        @method('PUT')
        <input type="hidden" name="edit_token" value="{{ $menu->edit_token }}">

        {{-- 1. Info --}}
        <div class="builder-card">
            <div class="builder-card-header">🏪 Informações do Restaurante</div>
            <div class="builder-card-body">
                <div class="form-group" style="margin-bottom:14px;">
                    <label>Nome do Restaurante *</label>
                    <input type="text" name="restaurant_name" class="form-control" value="{{ old('restaurant_name', $menu->restaurant_name) }}" required maxlength="100">
                </div>
                <div class="form-group" style="margin-bottom:14px;">
                    <label>Descrição / Slogan</label>
                    <textarea name="description" class="form-control" rows="2" maxlength="500">{{ old('description', $menu->description) }}</textarea>
                </div>
                <div class="item-row" style="margin-bottom:14px;">
                    <div class="form-group">
                        <label>Telefone</label>
                        <input type="text" name="phone" class="form-control" value="{{ old('phone', $menu->phone) }}" maxlength="30">
                    </div>
                    <div class="form-group">
                        <label>WhatsApp (com DDD)</label>
                        <input type="text" name="whatsapp" class="form-control" value="{{ old('whatsapp', $menu->whatsapp) }}" maxlength="30">
                    </div>
                </div>
                <div class="form-group" style="margin-bottom:14px;">
                    <label>Endereço</label>
                    <input type="text" name="address" class="form-control" value="{{ old('address', $menu->address) }}" maxlength="200">
                </div>
                <div class="item-row" style="margin-bottom:14px;">
                    <div class="form-group">
                        <label>Instagram</label>
                        <input type="text" name="instagram" class="form-control" value="{{ old('instagram', $menu->instagram) }}" maxlength="100">
                    </div>
                    <div class="form-group">
                        <label>Website</label>
                        <input type="url" name="website" class="form-control" value="{{ old('website', $menu->website) }}" maxlength="200">
                    </div>
                </div>
                <div class="item-row" style="margin-bottom:14px;">
                    <div class="form-group">
                        <label>URL da Logo</label>
                        <input type="url" name="logo_url" class="form-control" value="{{ old('logo_url', $menu->logo_url) }}" maxlength="500">
                    </div>
                    <div class="form-group">
                        <label>URL da Capa</label>
                        <input type="url" name="cover_url" class="form-control" value="{{ old('cover_url', $menu->cover_url) }}" maxlength="500">
                    </div>
                </div>
                <div>
                    <label style="font-weight:600; color:#444; font-size:13px; display:block; margin-bottom:8px;">Cores do Cardápio</label>
                    <div class="color-row">
                        <div class="color-field">
                            <label style="font-size:12px; color:#666;">Cor Principal</label>
                            <input type="color" id="primary_color" name="primary_color" value="{{ old('primary_color', $menu->primary_color) }}" class="color-preview">
                        </div>
                        <div class="color-field">
                            <label style="font-size:12px; color:#666;">Cor de Destaque</label>
                            <input type="color" id="accent_color" name="accent_color" value="{{ old('accent_color', $menu->accent_color) }}" class="color-preview">
                        </div>
                        <div style="flex:1; min-width:160px;">
                            <label style="font-size:12px; color:#666;">Prévia</label>
                            <div id="colorPreview" class="preview-bar"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Seções e Itens --}}
        <div class="builder-card">
            <div class="builder-card-header">📋 Seções e Itens do Cardápio</div>
            <div class="builder-card-body">
                <div id="sectionsContainer">
                    @foreach($menu->sections as $si => $section)
                    <div class="section-card" data-section="{{ $si }}">
                        <div class="section-header">
                            <span style="font-size:16px;">📂</span>
                            <input type="text" name="sections[{{ $si }}][name]" value="{{ $section->name }}" placeholder="Nome da seção" maxlength="100" required>
                            <button type="button" class="btn-remove" onclick="removeSection(this)">✕</button>
                        </div>
                        <div class="section-body">
                            <input type="text" name="sections[{{ $si }}][description]" class="form-control" value="{{ $section->description }}" placeholder="Descrição da seção (opcional)" style="margin-bottom:12px;" maxlength="300">
                            <div class="items-container">
                                @foreach($section->items as $ii => $item)
                                <div class="item-card">
                                    <div class="item-row" style="margin-bottom:10px;">
                                        <div class="form-group">
                                            <label>Nome do Item *</label>
                                            <input type="text" name="sections[{{ $si }}][items][{{ $ii }}][name]" class="form-control" value="{{ $item->name }}" maxlength="150" required>
                                        </div>
                                        <div class="form-group">
                                            <label>Preço (R$)</label>
                                            <input type="number" name="sections[{{ $si }}][items][{{ $ii }}][price]" class="form-control" value="{{ $item->price }}" step="0.01" min="0">
                                        </div>
                                    </div>
                                    <div class="form-group" style="margin-bottom:10px;">
                                        <label>Descrição</label>
                                        <input type="text" name="sections[{{ $si }}][items][{{ $ii }}][description]" class="form-control" value="{{ $item->description }}" maxlength="400">
                                    </div>
                                    <div class="form-group" style="margin-bottom:10px;">
                                        <label>Foto do Item (URL)</label>
                                        <input type="url" name="sections[{{ $si }}][items][{{ $ii }}][image_url]" class="form-control" value="{{ $item->image_url }}" maxlength="500">
                                    </div>
                                    <div style="display:flex; flex-wrap:wrap; gap:16px; align-items:center; margin-bottom:8px;">
                                        <div class="toggle-group">
                                            <span class="toggle-label">Disponível</span>
                                            <label class="toggle">
                                                <input type="checkbox" name="sections[{{ $si }}][items][{{ $ii }}][is_available]" value="1" {{ $item->is_available ? 'checked' : '' }}>
                                                <span class="toggle-slider"></span>
                                            </label>
                                        </div>
                                        <div class="toggle-group">
                                            <span class="toggle-label">⭐ Destaque</span>
                                            <label class="toggle">
                                                <input type="checkbox" name="sections[{{ $si }}][items][{{ $ii }}][is_featured]" value="1" {{ $item->is_featured ? 'checked' : '' }}>
                                                <span class="toggle-slider"></span>
                                            </label>
                                        </div>
                                        <div style="flex:1;">
                                            <div style="font-size:12px; color:#666; font-weight:600; margin-bottom:4px;">Etiquetas</div>
                                            <div class="badge-selector">
                                                @php $itemBadges = $item->badges ?? []; @endphp
                                                <label class="badge-chip vegan {{ in_array('vegan', $itemBadges) ? 'active' : '' }}" onclick="toggleBadge(this)">
                                                    <input type="checkbox" name="sections[{{ $si }}][items][{{ $ii }}][badges][]" value="vegan" {{ in_array('vegan', $itemBadges) ? 'checked' : '' }}> 🌿 Vegano
                                                </label>
                                                <label class="badge-chip veggie {{ in_array('vegetariano', $itemBadges) ? 'active' : '' }}" onclick="toggleBadge(this)">
                                                    <input type="checkbox" name="sections[{{ $si }}][items][{{ $ii }}][badges][]" value="vegetariano" {{ in_array('vegetariano', $itemBadges) ? 'checked' : '' }}> 🥗 Vegetariano
                                                </label>
                                                <label class="badge-chip gluten {{ in_array('sem_gluten', $itemBadges) ? 'active' : '' }}" onclick="toggleBadge(this)">
                                                    <input type="checkbox" name="sections[{{ $si }}][items][{{ $ii }}][badges][]" value="sem_gluten" {{ in_array('sem_gluten', $itemBadges) ? 'checked' : '' }}> 🌾 Sem Glúten
                                                </label>
                                                <label class="badge-chip spicy {{ in_array('picante', $itemBadges) ? 'active' : '' }}" onclick="toggleBadge(this)">
                                                    <input type="checkbox" name="sections[{{ $si }}][items][{{ $ii }}][badges][]" value="picante" {{ in_array('picante', $itemBadges) ? 'checked' : '' }}> 🌶️ Picante
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" class="btn-remove" style="position:absolute; top:10px; right:10px;" onclick="removeItem(this)">✕</button>
                                </div>
                                @endforeach
                            </div>
                            <button type="button" class="btn-add-item" onclick="addItem(this)">+ Adicionar Item</button>
                        </div>
                    </div>
                    @endforeach
                </div>
                <button type="button" class="btn-add-section" onclick="addSection()">+ Adicionar Seção</button>
            </div>
        </div>

        <button type="submit" class="submit-btn">💾 Salvar Alterações</button>
        <div style="text-align:center; margin-top:12px;">
            <a href="{{ $menu->publicUrl() }}" target="_blank" style="color:#7b4397; font-size:13px;">👁️ Ver cardápio público</a>
        </div>
    </form>
</div>

<template id="itemTemplate">
    <div class="item-card">
        <div class="item-row" style="margin-bottom:10px;">
            <div class="form-group">
                <label>Nome do Item *</label>
                <input type="text" name="__NAME__" class="form-control" placeholder="Ex: Pizza Margherita" maxlength="150" required>
            </div>
            <div class="form-group">
                <label>Preço (R$)</label>
                <input type="number" name="__PRICE__" class="form-control" placeholder="0,00" step="0.01" min="0">
            </div>
        </div>
        <div class="form-group" style="margin-bottom:10px;">
            <label>Descrição</label>
            <input type="text" name="__DESC__" class="form-control" placeholder="Ingredientes, modo de preparo..." maxlength="400">
        </div>
        <div class="form-group" style="margin-bottom:10px;">
            <label>Foto do Item (URL)</label>
            <input type="url" name="__IMG__" class="form-control" placeholder="https://..." maxlength="500">
        </div>
        <div style="display:flex; flex-wrap:wrap; gap:16px; align-items:center; margin-bottom:8px;">
            <div class="toggle-group">
                <span class="toggle-label">Disponível</span>
                <label class="toggle">
                    <input type="checkbox" name="__AVAIL__" value="1" checked>
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div class="toggle-group">
                <span class="toggle-label">⭐ Destaque</span>
                <label class="toggle">
                    <input type="checkbox" name="__FEAT__" value="1">
                    <span class="toggle-slider"></span>
                </label>
            </div>
            <div style="flex:1;">
                <div style="font-size:12px; color:#666; font-weight:600; margin-bottom:4px;">Etiquetas</div>
                <div class="badge-selector">
                    <label class="badge-chip vegan" onclick="toggleBadge(this)">
                        <input type="checkbox" name="__BADGES__" value="vegan"> 🌿 Vegano
                    </label>
                    <label class="badge-chip veggie" onclick="toggleBadge(this)">
                        <input type="checkbox" name="__BADGES__" value="vegetariano"> 🥗 Vegetariano
                    </label>
                    <label class="badge-chip gluten" onclick="toggleBadge(this)">
                        <input type="checkbox" name="__BADGES__" value="sem_gluten"> 🌾 Sem Glúten
                    </label>
                    <label class="badge-chip spicy" onclick="toggleBadge(this)">
                        <input type="checkbox" name="__BADGES__" value="picante"> 🌶️ Picante
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
let sectionCount = {{ $menu->sections->count() }};

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
            <input type="text" name="sections[${idx}][name]" placeholder="Nome da seção" maxlength="100" required>
            <button type="button" class="btn-remove" onclick="removeSection(this)">✕</button>
        </div>
        <div class="section-body">
            <input type="text" name="sections[${idx}][description]" class="form-control" placeholder="Descrição (opcional)" style="margin-bottom:12px;" maxlength="300">
            <div class="items-container"></div>
            <button type="button" class="btn-add-item" onclick="addItem(this)">+ Adicionar Item</button>
        </div>`;
    container.appendChild(div);
    div.querySelector('input').focus();
}

function removeSection(btn) {
    const section = btn.closest('.section-card');
    if (document.querySelectorAll('.section-card').length <= 1) {
        alert('O cardápio precisa ter pelo menos uma seção.');
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
    if (!valid) {
        e.preventDefault();
        alert('Cada seção precisa ter pelo menos um item.');
    }
});
</script>
@endpush
