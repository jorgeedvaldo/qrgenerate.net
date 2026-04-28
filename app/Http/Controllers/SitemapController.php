<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;

class SitemapController extends Controller
{
    private const CACHE_KEY = 'sitemap_xml';
    private const CACHE_TTL = 60 * 6; // 6 hours

    public function __invoke(ArticleService $articles)
    {
        $xml = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () use ($articles) {
            return $this->buildSitemap($articles);
        });

        return Response::make($xml, 200, [
            'Content-Type' => 'application/xml; charset=UTF-8',
        ]);
    }

    private function buildSitemap(ArticleService $articles): string
    {
        $baseUrl = config('qrgenerate.url');
        $today = date('Y-m-d');
        $urls = [];

        // ── Home pages ──
        $urls[] = ['loc' => "{$baseUrl}/", 'lastmod' => $today, 'changefreq' => 'daily', 'priority' => '1.0'];
        $urls[] = ['loc' => "{$baseUrl}/pt", 'lastmod' => $today, 'changefreq' => 'daily', 'priority' => '1.0'];

        // ── EN QR pages ──
        $enPages = config('qr_pages_en', []);
        foreach ($enPages as $slug => $page) {
            $urls[] = [
                'loc' => "{$baseUrl}/{$slug}",
                'lastmod' => $today,
                'changefreq' => 'weekly',
                'priority' => $this->pagePriority($slug),
            ];
        }

        // ── PT QR pages ──
        $ptPages = config('qr_pages_pt', []);
        foreach ($ptPages as $slug => $page) {
            $urls[] = [
                'loc' => "{$baseUrl}/pt/{$slug}",
                'lastmod' => $today,
                'changefreq' => 'weekly',
                'priority' => $this->pagePriority($slug),
            ];
        }

        // ── Article index pages ──
        $urls[] = ['loc' => "{$baseUrl}/articles", 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => '0.7'];
        $urls[] = ['loc' => "{$baseUrl}/pt/artigos", 'lastmod' => $today, 'changefreq' => 'weekly', 'priority' => '0.7'];

        // ── EN articles ──
        foreach ($articles->getAllByLocale('en') as $article) {
            $urls[] = [
                'loc' => "{$baseUrl}/articles/{$article['slug']}",
                'lastmod' => $article['updated_at'] ?? $article['date'] ?? $today,
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }

        // ── PT articles ──
        foreach ($articles->getAllByLocale('pt') as $article) {
            $urls[] = [
                'loc' => "{$baseUrl}/pt/artigos/{$article['slug']}",
                'lastmod' => $article['updated_at'] ?? $article['date'] ?? $today,
                'changefreq' => 'monthly',
                'priority' => '0.7',
            ];
        }

        return $this->renderXml($urls);
    }

    private function pagePriority(string $slug): string
    {
        // Main generator pages get highest priority
        $high = ['free-qr-code-generator', 'gerador-de-qr-code-gratis'];
        if (in_array($slug, $high)) return '0.9';

        return '0.8';
    }

    private function renderXml(array $urls): string
    {
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
        $xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

        foreach ($urls as $url) {
            $xml .= "  <url>\n";
            $xml .= "    <loc>{$url['loc']}</loc>\n";
            if (!empty($url['lastmod'])) {
                $xml .= "    <lastmod>{$url['lastmod']}</lastmod>\n";
            }
            $xml .= "    <changefreq>{$url['changefreq']}</changefreq>\n";
            $xml .= "    <priority>{$url['priority']}</priority>\n";
            $xml .= "  </url>\n";
        }

        $xml .= '</urlset>';

        return $xml;
    }
}
