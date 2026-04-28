<?php

namespace App\Http\Controllers;

use App\Services\ArticleService;

class HomeController extends Controller
{
    protected ArticleService $articleService;

    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    /**
     * English home page.
     */
    public function index()
    {
        $baseUrl = config('qrgenerate.url');

        // Fetch 3 recent articles
        $recentArticles = array_slice($this->articleService->getAllByLocale('en'), 0, 3);

        return view('pages.home', [
            'locale' => 'en',
            'seo' => [
                'title'          => 'Free QR Code Generator with Logo – No Signup Required',
                'description'    => 'Create free custom QR codes with logo, colors and print-ready downloads. No signup, no tracking and generated privately in your browser.',
                'keywords'       => config('qrgenerate.seo.keywords'),
                'canonical'      => "{$baseUrl}/",
                'og_title'       => 'Free QR Code Generator with Logo – No Signup Required',
                'og_description' => 'Create free custom QR codes with logo, colors and print-ready downloads. No signup, no tracking and generated privately in your browser.',
                'og_image'       => $baseUrl . config('qrgenerate.seo.og_image'),
                'og_type'        => config('qrgenerate.seo.og_type'),
                'hreflang'       => [
                    'en'        => "{$baseUrl}/",
                    'pt'        => "{$baseUrl}/pt",
                    'x-default' => "{$baseUrl}/",
                ],
            ],
            'qrTypes' => config('qrgenerate.qr_types'),
            'recentArticles' => $recentArticles,
        ]);
    }

    /**
     * Portuguese home page.
     */
    public function indexPt()
    {
        $baseUrl = config('qrgenerate.url');

        // Fetch 3 recent articles in PT
        $recentArticles = array_slice($this->articleService->getAllByLocale('pt'), 0, 3);

        return view('pages.home-pt', [
            'locale' => 'pt',
            'seo' => [
                'title'          => 'Gerador de QR Code Grátis com Logotipo – Sem Cadastro',
                'description'    => 'Crie QR Codes grátis com logotipo, cores e download para impressão. Sem cadastro, sem rastreamento e gerado directamente no navegador.',
                'canonical'      => "{$baseUrl}/pt",
                'og_title'       => 'Gerador de QR Code Grátis com Logotipo – Sem Cadastro',
                'og_description' => 'Crie QR Codes grátis com logotipo, cores e download para impressão. Sem cadastro, sem rastreamento e gerado directamente no navegador.',
                'og_image'       => $baseUrl . config('qrgenerate.seo.og_image'),
                'og_type'        => config('qrgenerate.seo.og_type'),
                'hreflang'       => [
                    'en'        => "{$baseUrl}/",
                    'pt'        => "{$baseUrl}/pt",
                    'x-default' => "{$baseUrl}/",
                ],
            ],
            'recentArticles' => $recentArticles,
        ]);
    }
}
