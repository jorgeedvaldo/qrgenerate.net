<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

class RobotsController extends Controller
{
    public function __invoke()
    {
        $sitemapUrl = config('qrgenerate.url') . '/sitemap.xml';

        $content = <<<ROBOTS
User-agent: *
Allow: /

Disallow: /admin
Disallow: /storage
Disallow: /vendor
Disallow: /api

Sitemap: {$sitemapUrl}
ROBOTS;

        return Response::make($content, 200, [
            'Content-Type' => 'text/plain; charset=UTF-8',
        ]);
    }
}
