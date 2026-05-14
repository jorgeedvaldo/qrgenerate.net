<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuSection;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function create()
    {
        return view('menu.create');
    }

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

    public function success(Request $request, string $slug)
    {
        $menu = Menu::where('slug', $slug)->firstOrFail();

        // Token comes from session flash or query string (returning visitor)
        $token = session('edit_token') ?? $request->query('token');

        return view('menu.success', compact('menu', 'token'));
    }

    public function show(string $slug)
    {
        $menu = Menu::with(['sections.items'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('menu.show', compact('menu'));
    }

    public function edit(Request $request, string $slug)
    {
        $menu = Menu::with(['sections.items'])->where('slug', $slug)->firstOrFail();

        if ($request->query('token') !== $menu->edit_token) {
            abort(403, 'Token de edição inválido.');
        }

        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, string $slug)
    {
        $menu = Menu::where('slug', $slug)->firstOrFail();

        if ($request->input('edit_token') !== $menu->edit_token) {
            abort(403, 'Token de edição inválido.');
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
            ->with('success', 'Cardápio atualizado com sucesso!');
    }

    private function saveSections(Menu $menu, array $sections): void
    {
        foreach ($sections as $sectionIndex => $sectionData) {
            $section = MenuSection::create([
                'menu_id'    => $menu->id,
                'name'       => $sectionData['name'],
                'description'=> $sectionData['description'] ?? null,
                'sort_order' => $sectionIndex,
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
