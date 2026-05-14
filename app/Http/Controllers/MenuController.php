<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuSection;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    // ── Landing pages (SEO) ─────────────────────────────────────────────────

    public function landingEn()
    {
        $baseUrl = config('qrgenerate.url');
        $seo = [
            'title'       => 'Free Digital Menu Generator for Restaurants – QR Code Included | QRGenerate',
            'description' => 'Create a beautiful digital menu for your restaurant in minutes. No signup required. Get a shareable URL and a QR Code your customers can scan instantly.',
            'keywords'    => 'digital menu generator, restaurant menu QR code, free digital menu, restaurant menu online, QR code menu, contactless menu',
            'canonical'   => "{$baseUrl}/digital-menu-generator",
            'og_title'    => 'Free Digital Menu Generator for Restaurants – QR Code Included',
            'og_description' => 'Create your restaurant digital menu in minutes. Free, no account needed. Share via URL or QR Code.',
            'hreflang'    => [
                'en'    => "{$baseUrl}/digital-menu-generator",
                'pt'    => "{$baseUrl}/pt/gerador-de-cardapio-digital",
                'x-default' => "{$baseUrl}/digital-menu-generator",
            ],
        ];

        return view('menu.landing', ['menuLocale' => 'en', 'seo' => $seo, 'locale' => 'en']);
    }

    public function landingPt()
    {
        $baseUrl = config('qrgenerate.url');
        $seo = [
            'title'       => 'Gerador de Cardápio Digital para Restaurantes – QR Code Grátis | QRGenerate',
            'description' => 'Crie um cardápio digital bonito para o seu restaurante em minutos. Sem cadastro. Gera link exclusivo e QR Code para seus clientes escanearem.',
            'keywords'    => 'gerador cardápio digital, cardápio digital restaurante, QR code cardápio, cardápio online grátis, cardápio digital qr code, cardápio digital sem cadastro',
            'canonical'   => config('qrgenerate.url') . '/pt/gerador-de-cardapio-digital',
            'og_title'    => 'Gerador de Cardápio Digital para Restaurantes – QR Code Grátis',
            'og_description' => 'Crie o cardápio digital do seu restaurante em minutos. Grátis, sem cadastro. Compartilhe via URL ou QR Code.',
            'hreflang'    => [
                'pt'    => config('qrgenerate.url') . '/pt/gerador-de-cardapio-digital',
                'en'    => config('qrgenerate.url') . '/digital-menu-generator',
                'x-default' => config('qrgenerate.url') . '/digital-menu-generator',
            ],
        ];

        return view('menu.landing', ['menuLocale' => 'pt', 'seo' => $seo, 'locale' => 'pt']);
    }

    // ── Create form ─────────────────────────────────────────────────────────

    public function createEn()
    {
        $baseUrl = config('qrgenerate.url');
        $seo = [
            'title'       => 'Create Your Restaurant Digital Menu – Free QR Code Generator | QRGenerate',
            'description' => 'Build your restaurant digital menu now. Add sections, items, prices and get a shareable URL and QR code instantly. No signup required.',
            'canonical'   => "{$baseUrl}/menu/create",
            'hreflang'    => [
                'en'    => "{$baseUrl}/menu/create",
                'pt'    => "{$baseUrl}/cardapio/criar",
                'x-default' => "{$baseUrl}/menu/create",
            ],
        ];

        return view('menu.create', ['menuLocale' => 'en', 'seo' => $seo, 'locale' => 'en']);
    }

    public function createPt()
    {
        $baseUrl = config('qrgenerate.url');
        $seo = [
            'title'       => 'Criar Cardápio Digital – Gerador de QR Code Grátis para Restaurantes | QRGenerate',
            'description' => 'Monte o cardápio digital do seu restaurante agora. Adicione seções, itens e preços e receba uma URL e QR Code na hora. Sem cadastro.',
            'canonical'   => "{$baseUrl}/cardapio/criar",
            'hreflang'    => [
                'pt'    => "{$baseUrl}/cardapio/criar",
                'en'    => "{$baseUrl}/menu/create",
                'x-default' => "{$baseUrl}/menu/create",
            ],
        ];

        return view('menu.create', ['menuLocale' => 'pt', 'seo' => $seo, 'locale' => 'pt']);
    }

    // ── Store ────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $data = $request->validate([
            'restaurant_name'          => 'required|string|max:100',
            'description'              => 'nullable|string|max:500',
            'logo_url'                 => 'nullable|url|max:500',
            'cover_url'                => 'nullable|url|max:500',
            'phone'                    => 'nullable|string|max:30',
            'address'                  => 'nullable|string|max:200',
            'website'                  => 'nullable|url|max:200',
            'whatsapp'                 => 'nullable|string|max:30',
            'instagram'                => 'nullable|string|max:100',
            'facebook'                 => 'nullable|string|max:100',
            'primary_color'            => 'nullable|string|max:7',
            'accent_color'             => 'nullable|string|max:7',
            'sections'                 => 'required|array|min:1',
            'sections.*.name'          => 'required|string|max:100',
            'sections.*.description'   => 'nullable|string|max:300',
            'sections.*.items'         => 'nullable|array',
            'sections.*.items.*.name'  => 'required|string|max:150',
            'sections.*.items.*.description' => 'nullable|string|max:400',
            'sections.*.items.*.price'       => 'nullable|numeric|min:0|max:99999',
            'sections.*.items.*.image_url'   => 'nullable|url|max:500',
            'sections.*.items.*.badges'      => 'nullable|array',
        ]);

        $menu = Menu::create([
            'slug'            => Menu::generateUniqueSlug($data['restaurant_name']),
            'edit_token'      => Str::uuid()->toString(),
            'restaurant_name' => $data['restaurant_name'],
            'description'     => $data['description'] ?? null,
            'logo_url'        => $data['logo_url'] ?? null,
            'cover_url'       => $data['cover_url'] ?? null,
            'phone'           => $data['phone'] ?? null,
            'address'         => $data['address'] ?? null,
            'website'         => $data['website'] ?? null,
            'whatsapp'        => $data['whatsapp'] ?? null,
            'instagram'       => $data['instagram'] ?? null,
            'facebook'        => $data['facebook'] ?? null,
            'primary_color'   => $data['primary_color'] ?? '#d97706',
            'accent_color'    => $data['accent_color'] ?? '#92400e',
        ]);

        $this->saveSections($menu, $data['sections'] ?? []);

        return redirect()->route('menu.success', ['slug' => $menu->slug])
            ->with('edit_token', $menu->edit_token);
    }

    // ── Success ──────────────────────────────────────────────────────────────

    public function success(Request $request, string $slug)
    {
        $menu  = Menu::where('slug', $slug)->firstOrFail();
        $token = session('edit_token') ?? $request->query('token');

        return view('menu.success', compact('menu', 'token'));
    }

    // ── Public show ──────────────────────────────────────────────────────────

    public function show(string $slug)
    {
        $menu = Menu::with(['sections.items'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('menu.show', compact('menu'));
    }

    // ── Edit ─────────────────────────────────────────────────────────────────

    public function editPt(Request $request, string $slug)
    {
        return $this->editForm($request, $slug, 'pt');
    }

    public function editEn(Request $request, string $slug)
    {
        return $this->editForm($request, $slug, 'en');
    }

    private function editForm(Request $request, string $slug, string $menuLocale)
    {
        $menu = Menu::with(['sections.items'])->where('slug', $slug)->firstOrFail();

        if ($request->query('token') !== $menu->edit_token) {
            abort(403, $menuLocale === 'pt' ? 'Token de edição inválido.' : 'Invalid edit token.');
        }

        return view('menu.edit', compact('menu', 'menuLocale'));
    }

    // ── Update ───────────────────────────────────────────────────────────────

    public function update(Request $request, string $slug)
    {
        $menu = Menu::where('slug', $slug)->firstOrFail();

        if ($request->input('edit_token') !== $menu->edit_token) {
            abort(403, 'Invalid edit token.');
        }

        $data = $request->validate([
            'restaurant_name'          => 'required|string|max:100',
            'description'              => 'nullable|string|max:500',
            'logo_url'                 => 'nullable|url|max:500',
            'cover_url'                => 'nullable|url|max:500',
            'phone'                    => 'nullable|string|max:30',
            'address'                  => 'nullable|string|max:200',
            'website'                  => 'nullable|url|max:200',
            'whatsapp'                 => 'nullable|string|max:30',
            'instagram'                => 'nullable|string|max:100',
            'facebook'                 => 'nullable|string|max:100',
            'primary_color'            => 'nullable|string|max:7',
            'accent_color'             => 'nullable|string|max:7',
            'sections'                 => 'required|array|min:1',
            'sections.*.name'          => 'required|string|max:100',
            'sections.*.description'   => 'nullable|string|max:300',
            'sections.*.items'         => 'nullable|array',
            'sections.*.items.*.name'  => 'required|string|max:150',
            'sections.*.items.*.description' => 'nullable|string|max:400',
            'sections.*.items.*.price'       => 'nullable|numeric|min:0|max:99999',
            'sections.*.items.*.image_url'   => 'nullable|url|max:500',
            'sections.*.items.*.badges'      => 'nullable|array',
        ]);

        $menu->update([
            'restaurant_name' => $data['restaurant_name'],
            'description'     => $data['description'] ?? null,
            'logo_url'        => $data['logo_url'] ?? null,
            'cover_url'       => $data['cover_url'] ?? null,
            'phone'           => $data['phone'] ?? null,
            'address'         => $data['address'] ?? null,
            'website'         => $data['website'] ?? null,
            'whatsapp'        => $data['whatsapp'] ?? null,
            'instagram'       => $data['instagram'] ?? null,
            'facebook'        => $data['facebook'] ?? null,
            'primary_color'   => $data['primary_color'] ?? '#d97706',
            'accent_color'    => $data['accent_color'] ?? '#92400e',
        ]);

        $menu->sections()->delete();
        $this->saveSections($menu, $data['sections'] ?? []);

        return redirect()->route('menu.show', $menu->slug)
            ->with('success', 'Menu updated successfully!');
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    private function saveSections(Menu $menu, array $sections): void
    {
        foreach ($sections as $sectionIndex => $sectionData) {
            $section = MenuSection::create([
                'menu_id'     => $menu->id,
                'name'        => $sectionData['name'],
                'description' => $sectionData['description'] ?? null,
                'sort_order'  => $sectionIndex,
            ]);

            foreach (($sectionData['items'] ?? []) as $itemIndex => $itemData) {
                MenuItem::create([
                    'menu_section_id' => $section->id,
                    'name'            => $itemData['name'],
                    'description'     => $itemData['description'] ?? null,
                    'price'           => isset($itemData['price']) && $itemData['price'] !== '' ? $itemData['price'] : null,
                    'image_url'       => $itemData['image_url'] ?? null,
                    'is_available'    => ($itemData['is_available'] ?? '1') === '1',
                    'is_featured'     => ($itemData['is_featured'] ?? '0') === '1',
                    'badges'          => $itemData['badges'] ?? null,
                    'sort_order'      => $itemIndex,
                ]);
            }
        }
    }
}
