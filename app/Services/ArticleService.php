<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\File;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\FrontMatter\Output\RenderedContentWithFrontMatter;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\MarkdownConverter;

class ArticleService
{
    private const CACHE_PREFIX = 'articles';
    private const CACHE_TTL = 60 * 24 * 7; // 7 days in minutes

    /**
     * Get all articles for a locale, sorted by date descending.
     */
    public function getAllByLocale(string $locale): array
    {
        $cacheKey = self::CACHE_PREFIX . ".index.{$locale}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($locale) {
            return $this->loadAllFromDisk($locale);
        });
    }

    /**
     * Get a single article by slug and locale.
     */
    public function getBySlug(string $slug, string $locale): ?array
    {
        $cacheKey = self::CACHE_PREFIX . ".{$locale}.{$slug}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($slug, $locale) {
            return $this->loadFromDisk($slug, $locale);
        });
    }

    /**
     * Get related articles based on shared tags or category.
     */
    public function getRelated(array $article, int $limit = 3): array
    {
        $all = $this->getAllByLocale($article['locale'] ?? 'en');
        $scored = [];

        foreach ($all as $other) {
            if ($other['slug'] === $article['slug']) continue;

            $score = 0;
            // Same category = 2 points
            if (($other['category'] ?? '') === ($article['category'] ?? '')) {
                $score += 2;
            }
            // Shared tags = 1 point each
            $sharedTags = array_intersect($other['tags'] ?? [], $article['tags'] ?? []);
            $score += count($sharedTags);

            if ($score > 0) {
                $other['_score'] = $score;
                $scored[] = $other;
            }
        }

        usort($scored, fn($a, $b) => $b['_score'] <=> $a['_score']);

        return array_slice($scored, 0, $limit);
    }

    /**
     * Rebuild cache for all articles in all locales.
     */
    public function rebuildCache(): array
    {
        $stats = ['en' => 0, 'pt' => 0];

        foreach (['en', 'pt'] as $locale) {
            // Clear index cache
            Cache::forget(self::CACHE_PREFIX . ".index.{$locale}");

            $articles = $this->loadAllFromDisk($locale);
            Cache::put(self::CACHE_PREFIX . ".index.{$locale}", $articles, self::CACHE_TTL);

            // Cache each full article individually (with body + toc)
            foreach ($articles as $article) {
                $fullArticle = $this->loadFromDisk($article['slug'], $locale);
                if ($fullArticle) {
                    $key = self::CACHE_PREFIX . ".{$locale}.{$article['slug']}";
                    Cache::put($key, $fullArticle, self::CACHE_TTL);
                    $stats[$locale]++;
                }
            }
        }

        return $stats;
    }

    /**
     * Load all articles from disk for a given locale.
     */
    private function loadAllFromDisk(string $locale): array
    {
        $dir = base_path("content/articles/{$locale}");

        if (!File::isDirectory($dir)) {
            return [];
        }

        $articles = [];

        foreach (File::glob("{$dir}/*.md") as $file) {
            $parsed = $this->parseMarkdownFile($file, $locale);
            if ($parsed) {
                // For the index, we don't need the full HTML body
                $articles[] = [
                    'slug'        => $parsed['slug'],
                    'title'       => $parsed['title'],
                    'description' => $parsed['description'],
                    'date'        => $parsed['date'],
                    'updated_at'  => $parsed['updated_at'] ?? $parsed['date'],
                    'category'    => $parsed['category'] ?? '',
                    'tags'        => $parsed['tags'] ?? [],
                    'cover'       => $parsed['cover'] ?? null,
                    'locale'      => $locale,
                    'alternate_slug' => $parsed['alternate_slug'] ?? null,
                ];
            }
        }

        // Sort by date descending
        usort($articles, fn($a, $b) => strcmp($b['date'], $a['date']));

        return $articles;
    }

    /**
     * Load a single article from disk.
     */
    private function loadFromDisk(string $slug, string $locale): ?array
    {
        $file = base_path("content/articles/{$locale}/{$slug}.md");

        if (!File::exists($file)) {
            return null;
        }

        return $this->parseMarkdownFile($file, $locale);
    }

    /**
     * Parse a Markdown file with front matter into an article array.
     */
    private function parseMarkdownFile(string $filePath, string $locale): ?array
    {
        $environment = new Environment([
            'heading_permalink' => [
                'html_class' => 'heading-anchor',
                'insert' => 'none', // Don't insert anchor links
                'symbol' => '',
            ],
        ]);

        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new FrontMatterExtension());
        $environment->addExtension(new HeadingPermalinkExtension());

        $converter = new MarkdownConverter($environment);
        $content = file_get_contents($filePath);
        $result = $converter->convert($content);

        if (!$result instanceof RenderedContentWithFrontMatter) {
            return null;
        }

        $meta = $result->getFrontMatter();
        $html = $result->getContent();

        // Sanitize: strip script tags
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);

        // Extract headings for Table of Contents
        $toc = [];
        preg_match_all('/<(h[23])[^>]*id="([^"]*)"[^>]*>(.*?)<\/\1>/i', $html, $matches, PREG_SET_ORDER);
        foreach ($matches as $match) {
            $toc[] = [
                'level' => $match[1] === 'h2' ? 2 : 3,
                'id'    => $match[2],
                'text'  => strip_tags($match[3]),
            ];
        }

        return [
            'slug'           => $meta['slug'] ?? basename($filePath, '.md'),
            'title'          => $meta['title'] ?? 'Untitled',
            'description'    => $meta['description'] ?? '',
            'date'           => $meta['date'] ?? '',
            'updated_at'     => $meta['updated_at'] ?? null,
            'category'       => $meta['category'] ?? '',
            'tags'           => $meta['tags'] ?? [],
            'cover'          => $meta['cover'] ?? null,
            'canonical'      => $meta['canonical'] ?? null,
            'alternate_slug' => $meta['alternate_slug'] ?? null,
            'locale'         => $locale,
            'body'           => $html,
            'toc'            => $toc,
        ];
    }
}
