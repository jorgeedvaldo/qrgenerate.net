<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;

class ArticleController extends Controller
{
    public function __construct(
        private ArticleService $articles
    ) {}

    /**
     * List all articles for a locale.
     */
    public function index(string $locale = 'en')
    {
        $articles = $this->articles->getAllByLocale($locale);
        $baseUrl = config('qrgenerate.url');

        $isEn = $locale === 'en';

        return view('pages.articles.index', [
            'locale'   => $locale,
            'articles' => $articles,
            'seo'      => [
                'title'       => $isEn
                    ? 'QR Code Articles & Guides | QrGenerate'
                    : 'Artigos e Guias sobre QR Code | QrGenerate',
                'description' => $isEn
                    ? 'Learn everything about QR codes: how to create them, best practices, and use cases for your business.'
                    : 'Aprenda tudo sobre QR Codes: como criar, boas práticas e casos de uso para o seu negócio.',
                'canonical'   => $isEn ? "{$baseUrl}/articles" : "{$baseUrl}/pt/artigos",
                'hreflang'    => [
                    'en'        => "{$baseUrl}/articles",
                    'pt'        => "{$baseUrl}/pt/artigos",
                    'x-default' => "{$baseUrl}/articles",
                ],
            ],
        ]);
    }

    /**
     * Show a single article.
     */
    public function show(string $slug, string $locale = 'en')
    {
        $article = $this->articles->getBySlug($slug, $locale);

        if (!$article) {
            abort(404);
        }

        $baseUrl = config('qrgenerate.url');
        $isEn = $locale === 'en';

        // Build canonical
        $canonical = $article['canonical']
            ?? ($isEn ? "{$baseUrl}/articles/{$slug}" : "{$baseUrl}/pt/artigos/{$slug}");

        // Build hreflang
        $hreflang = [];
        if ($isEn) {
            $hreflang['en'] = "{$baseUrl}/articles/{$slug}";
            $hreflang['x-default'] = "{$baseUrl}/articles/{$slug}";
            if (!empty($article['alternate_slug'])) {
                $hreflang['pt'] = "{$baseUrl}/pt/artigos/{$article['alternate_slug']}";
            }
        } else {
            $hreflang['pt'] = "{$baseUrl}/pt/artigos/{$slug}";
            if (!empty($article['alternate_slug'])) {
                $hreflang['en'] = "{$baseUrl}/articles/{$article['alternate_slug']}";
                $hreflang['x-default'] = "{$baseUrl}/articles/{$article['alternate_slug']}";
            }
        }

        $related = $this->articles->getRelated($article);

        return view('pages.articles.show', [
            'locale'   => $locale,
            'article'  => $article,
            'related'  => $related,
            'seo'      => [
                'title'          => $article['title'] . ' | QrGenerate',
                'description'    => $article['description'],
                'canonical'      => $canonical,
                'og_title'       => $article['title'],
                'og_description' => $article['description'],
                'og_type'        => 'article',
                'hreflang'       => $hreflang,
            ],
        ]);
    }
}
