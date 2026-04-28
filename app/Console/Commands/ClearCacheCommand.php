<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class ClearCacheCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'qrgenerate:clear-cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear QrGenerate specific caches.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Clearing QrGenerate specific caches...');

        Cache::forget('articles_en');
        Cache::forget('articles_pt');
        Cache::forget('sitemap_xml');

        $this->info('Cache cleared successfully! \u{1F5D1}');
    }
}
