<?php

namespace App\Console\Commands;

use App\Services\ArticleService;
use Illuminate\Console\Command;

class RebuildArticleCache extends Command
{
    protected $signature = 'articles:cache';
    protected $description = 'Rebuild the article cache from Markdown files';

    public function handle(ArticleService $service): int
    {
        $this->info('Rebuilding article cache...');

        $stats = $service->rebuildCache();

        foreach ($stats as $locale => $count) {
            $this->line("  [{$locale}] {$count} articles cached.");
        }

        $total = array_sum($stats);
        $this->info("Done! {$total} articles cached successfully.");

        return self::SUCCESS;
    }
}
