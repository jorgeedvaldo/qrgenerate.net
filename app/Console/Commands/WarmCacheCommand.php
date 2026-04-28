<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ArticleService;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Cache;

class WarmCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qrgenerate:warm-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Warm up application caches (articles, sitemap) and validate content.';

    /**
     * Execute the console command.
     */
    public function handle(ArticleService $articles)
    {
        $this->info('Starting QrGenerate cache warmup and validation...');

        // 1. Rebuild Articles Cache
        $this->info("\n[1/4] Rebuilding Articles Cache...");
        Cache::forget('articles_en');
        Cache::forget('articles_pt');
        
        $enArticles = $articles->getAllByLocale('en');
        $ptArticles = $articles->getAllByLocale('pt');
        
        $this->line("  [en] " . count($enArticles) . " articles cached.");
        $this->line("  [pt] " . count($ptArticles) . " articles cached.");

        // 2. Validate Configured Pages & Slugs
        $this->info("\n[2/4] Validating Config Pages...");
        $enPages = config('qr_pages_en', []);
        $ptPages = config('qr_pages_pt', []);
        
        $slugs = [];
        $duplicateSlugs = false;

        foreach ($enPages as $slug => $page) {
            if (in_array($slug, $slugs)) {
                $this->error("  [!] Duplicate slug found: {$slug} (en)");
                $duplicateSlugs = true;
            }
            $slugs[] = $slug;
            
            // Check title/desc
            if (empty($page['title']) || empty($page['meta_description'])) {
                $this->warn("  [!] Missing Title or Meta Description for {$slug} (en)");
            }
        }

        $slugs = [];
        foreach ($ptPages as $slug => $page) {
            if (in_array($slug, $slugs)) {
                $this->error("  [!] Duplicate slug found: {$slug} (pt)");
                $duplicateSlugs = true;
            }
            $slugs[] = $slug;
            
            if (empty($page['title']) || empty($page['meta_description'])) {
                $this->warn("  [!] Missing Title or Meta Description for {$slug} (pt)");
            }
        }

        if (!$duplicateSlugs) {
            $this->line("  All pages validated successfully. No duplicate slugs.");
        }

        // 3. Validate Article Metadata
        $this->info("\n[3/4] Validating Article Metadata...");
        $articlesMissingSeo = 0;
        foreach (array_merge($enArticles, $ptArticles) as $article) {
            if (empty($article['title']) || empty($article['description'])) {
                $this->warn("  [!] Missing Title or Description in article: {$article['slug']}");
                $articlesMissingSeo++;
            }
        }
        if ($articlesMissingSeo === 0) {
            $this->line("  All articles have valid title and description.");
        }

        // 4. Rebuild Sitemap Cache
        $this->info("\n[4/4] Rebuilding Sitemap Cache...");
        Cache::forget('sitemap_xml');
        $sitemapController = new SitemapController();
        // Invoke it to trigger cache generation
        try {
            $sitemapController->__invoke($articles);
            $this->line("  Sitemap rebuilt and cached successfully.");
        } catch (\Exception $e) {
            $this->error("  Failed to rebuild sitemap: " . $e->getMessage());
        }

        $this->info("\nCache warm up completed successfully! \u{1F680}");
    }
}
