<?php

namespace App\Http\Controllers;

class QrPageController extends Controller
{
    /**
     * Show an English QR type page.
     */
    public function show(string $slug)
    {
        $page = config("qr_pages_en.{$slug}");

        if (!$page) {
            abort(404);
        }

        return $this->renderPage($page, $slug, 'en');
    }

    /**
     * Show a Portuguese QR type page.
     */
    public function showPt(string $slug)
    {
        $page = config("qr_pages_pt.{$slug}");

        if (!$page) {
            abort(404);
        }

        return $this->renderPage($page, $slug, 'pt');
    }

    /**
     * Render the QR type page view with SEO data.
     */
    private function renderPage(array $page, string $slug, string $locale)
    {
        $baseUrl = config('qrgenerate.url');

        // Build canonical URL
        $canonical = $locale === 'pt'
            ? "{$baseUrl}/pt/{$slug}"
            : "{$baseUrl}/{$slug}";

        // Build hreflang alternates
        $hreflang = [];

        if ($locale === 'en') {
            $hreflang['en'] = "{$baseUrl}/{$slug}";
            $hreflang['x-default'] = "{$baseUrl}/{$slug}";
            if (!empty($page['alternate_slug'])) {
                $hreflang['pt'] = "{$baseUrl}/pt/{$page['alternate_slug']}";
            }
        } else {
            $hreflang['pt'] = "{$baseUrl}/pt/{$slug}";
            if (!empty($page['alternate_slug'])) {
                $hreflang['en'] = "{$baseUrl}/{$page['alternate_slug']}";
                $hreflang['x-default'] = "{$baseUrl}/{$page['alternate_slug']}";
            }
        }

        // Resolve related pages to full data
        $configKey = $locale === 'pt' ? 'qr_pages_pt' : 'qr_pages_en';
        $relatedPages = [];
        foreach ($page['related_pages'] ?? [] as $relSlug) {
            $rel = config("{$configKey}.{$relSlug}");
            if ($rel) {
                $relatedPages[] = [
                    'slug'  => $relSlug,
                    'title' => $rel['h1'],
                    'url'   => $locale === 'pt' ? "/pt/{$relSlug}" : "/{$relSlug}",
                ];
            }
        }

        return view('pages.qr-type', [
            'page'   => $page,
            'locale' => $locale,
            'seo'    => [
                'title'       => $page['title'],
                'description' => $page['meta_description'],
                'canonical'   => $canonical,
                'og_title'    => $page['title'],
                'og_description' => $page['meta_description'],
                'hreflang'    => $hreflang,
            ],
            'relatedPages' => $relatedPages,
        ]);
    }
}
