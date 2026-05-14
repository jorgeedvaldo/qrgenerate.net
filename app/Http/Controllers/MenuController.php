<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuSection;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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
            'logo_file'                => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'logo_url'                 => 'nullable|url|max:500',
            'cover_file'               => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cover_url'                => 'nullable|url|max:500',
            'phone'                    => 'nullable|string|max:30',
            'address'                  => 'nullable|string|max:200',
            'website'                  => 'nullable|url|max:200',
            'whatsapp'                 => 'nullable|string|max:30',
            'instagram'                => 'nullable|string|max:100',
            'facebook'                 => 'nullable|string|max:100',
            'contact_email'            => 'nullable|email|max:200',
            'recovery_email'           => 'nullable|email|max:200',
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
            'sections.*.items.*.image_file'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sections.*.items.*.badges'      => 'nullable|array',
        ]);

        $slug = Menu::generateUniqueSlug($data['restaurant_name']);

        $menu = Menu::create([
            'slug'            => $slug,
            'edit_token'      => Str::uuid()->toString(),
            'restaurant_name' => $data['restaurant_name'],
            'description'     => $data['description'] ?? null,
            'logo_url'        => $this->resolveImageUrl($request, 'logo_file', 'logo_url', $slug),
            'cover_url'       => $this->resolveImageUrl($request, 'cover_file', 'cover_url', $slug),
            'phone'           => $data['phone'] ?? null,
            'address'         => $data['address'] ?? null,
            'website'         => $data['website'] ?? null,
            'whatsapp'        => $data['whatsapp'] ?? null,
            'instagram'       => $data['instagram'] ?? null,
            'facebook'        => $data['facebook'] ?? null,
            'contact_email'   => $data['contact_email'] ?? null,
            'recovery_email'  => $data['recovery_email'] ?? null,
            'primary_color'   => $data['primary_color'] ?? '#d97706',
            'accent_color'    => $data['accent_color'] ?? '#92400e',
        ]);

        $this->saveSections($menu, $data['sections'] ?? [], $request);

        if ($menu->recovery_email) {
            $editLink = $menu->editUrl();
            $restaurantName = $menu->restaurant_name;
            Mail::raw(
                "Olá!\n\nSeu cardápio digital foi criado com sucesso no QRGenerate.net.\n\nGuarde o link abaixo para editar seu cardápio quando precisar:\n\n{$editLink}\n\nNão compartilhe este link publicamente – qualquer pessoa com ele pode editar seu cardápio.\n\nAtenciosamente,\nEquipe QRGenerate.net",
                function ($msg) use ($menu) {
                    $msg->to($menu->recovery_email)
                        ->subject('Seu link de edição do cardápio – ' . $menu->restaurant_name);
                }
            );
        }

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
            'logo_file'                => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'logo_url'                 => 'nullable|url|max:500',
            'cover_file'               => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cover_url'                => 'nullable|url|max:500',
            'phone'                    => 'nullable|string|max:30',
            'address'                  => 'nullable|string|max:200',
            'website'                  => 'nullable|url|max:200',
            'whatsapp'                 => 'nullable|string|max:30',
            'instagram'                => 'nullable|string|max:100',
            'facebook'                 => 'nullable|string|max:100',
            'contact_email'            => 'nullable|email|max:200',
            'recovery_email'           => 'nullable|email|max:200',
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
            'sections.*.items.*.image_file'  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'sections.*.items.*.badges'      => 'nullable|array',
        ]);

        $menu->update([
            'restaurant_name' => $data['restaurant_name'],
            'description'     => $data['description'] ?? null,
            'logo_url'        => $this->resolveImageUrl($request, 'logo_file', 'logo_url', $menu->slug, $menu->logo_url),
            'cover_url'       => $this->resolveImageUrl($request, 'cover_file', 'cover_url', $menu->slug, $menu->cover_url),
            'phone'           => $data['phone'] ?? null,
            'address'         => $data['address'] ?? null,
            'website'         => $data['website'] ?? null,
            'whatsapp'        => $data['whatsapp'] ?? null,
            'instagram'       => $data['instagram'] ?? null,
            'facebook'        => $data['facebook'] ?? null,
            'contact_email'   => $data['contact_email'] ?? null,
            'recovery_email'  => $data['recovery_email'] ?? null,
            'primary_color'   => $data['primary_color'] ?? '#d97706',
            'accent_color'    => $data['accent_color'] ?? '#92400e',
        ]);

        $menu->sections()->delete();
        $this->saveSections($menu, $data['sections'] ?? [], $request);

        return redirect()->route('menu.show', $menu->slug)
            ->with('success', 'Menu updated successfully!');
    }

    // ── Helpers ──────────────────────────────────────────────────────────────

    private function saveSections(Menu $menu, array $sections, Request $request): void
    {
        foreach ($sections as $sectionIndex => $sectionData) {
            $section = MenuSection::create([
                'menu_id'     => $menu->id,
                'name'        => $sectionData['name'],
                'description' => $sectionData['description'] ?? null,
                'sort_order'  => $sectionIndex,
            ]);

            foreach (($sectionData['items'] ?? []) as $itemIndex => $itemData) {
                // Resolve item image: uploaded file takes priority over URL
                $imageUrl = $itemData['image_url'] ?? null;
                $itemFile = $request->file("sections.{$sectionIndex}.items.{$itemIndex}.image_file");
                if ($itemFile && $itemFile->isValid()) {
                    $path = $itemFile->store("menus/{$menu->slug}/items", 'public');
                    $imageUrl = '/storage/' . $path;
                }

                MenuItem::create([
                    'menu_section_id' => $section->id,
                    'name'            => $itemData['name'],
                    'description'     => $itemData['description'] ?? null,
                    'price'           => isset($itemData['price']) && $itemData['price'] !== '' ? $itemData['price'] : null,
                    'image_url'       => $imageUrl,
                    'is_available'    => ($itemData['is_available'] ?? '1') === '1',
                    'is_featured'     => ($itemData['is_featured'] ?? '0') === '1',
                    'badges'          => $itemData['badges'] ?? null,
                    'sort_order'      => $itemIndex,
                ]);
            }
        }
    }

    // ── Link Recovery ────────────────────────────────────────────────────────

    public function recoverForm()
    {
        return view('menu.recover');
    }

    public function recoverSend(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $menus = Menu::where('recovery_email', $request->email)->get();

        if ($menus->isNotEmpty()) {
            $menuList = $menus;
            Mail::raw(
                $this->buildRecoveryEmailBody($menus->all()),
                function ($msg) use ($request, $menus) {
                    $subject = $menus->count() === 1
                        ? 'Seu link de edição do cardápio – ' . $menus->first()->restaurant_name
                        : 'Seus links de edição de cardápio – QRGenerate.net';
                    $msg->to($request->email)->subject($subject);
                }
            );
        }

        // Always show success — don't leak whether email exists
        return back()->with('sent', true);
    }

    private function buildRecoveryEmailBody(array $menus): string
    {
        $body = "Olá!\n\nRecebemos uma solicitação de recuperação do link de edição do seu cardápio no QRGenerate.net.\n\n";

        foreach ($menus as $menu) {
            $body .= "Restaurante: {$menu->restaurant_name}\n";
            $body .= "Link de edição: {$menu->editUrl()}\n\n";
        }

        $body .= "Não compartilhe estes links publicamente – qualquer pessoa com eles pode editar seu cardápio.\n\n";
        $body .= "Se você não solicitou este e-mail, pode ignorá-lo com segurança.\n\n";
        $body .= "Atenciosamente,\nEquipe QRGenerate.net";

        return $body;
    }

    private function resolveImageUrl(
        Request $request,
        string $fileInput,
        string $urlInput,
        string $slug,
        ?string $existing = null
    ): ?string {
        if ($request->hasFile($fileInput) && $request->file($fileInput)->isValid()) {
            // Delete previously uploaded file (not external URLs)
            if ($existing && str_starts_with($existing, '/storage/')) {
                Storage::disk('public')->delete(ltrim(str_replace('/storage', '', $existing), '/'));
            }
            $path = $request->file($fileInput)->store("menus/{$slug}", 'public');
            return '/storage/' . $path;
        }

        $url = $request->input($urlInput);
        return $url ?: $existing;
    }
}
