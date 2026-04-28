<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * English home page.
     */
    public function index()
    {
        $baseUrl = config('qrgenerate.url');

        return view('pages.home', [
            'locale' => 'en',
            'seo' => [
                'title'          => config('qrgenerate.seo.title'),
                'description'    => config('qrgenerate.seo.description'),
                'keywords'       => config('qrgenerate.seo.keywords'),
                'canonical'      => "{$baseUrl}/",
                'og_title'       => config('qrgenerate.seo.title'),
                'og_description' => config('qrgenerate.seo.description'),
                'og_image'       => $baseUrl . config('qrgenerate.seo.og_image'),
                'og_type'        => config('qrgenerate.seo.og_type'),
                'hreflang'       => [
                    'en'        => "{$baseUrl}/",
                    'pt'        => "{$baseUrl}/pt",
                    'x-default' => "{$baseUrl}/",
                ],
            ],
            'qrTypes' => config('qrgenerate.qr_types'),
        ]);
    }

    /**
     * Portuguese home page.
     */
    public function indexPt()
    {
        $baseUrl = config('qrgenerate.url');

        return view('pages.home-pt', [
            'locale' => 'pt',
            'seo' => [
                'title'          => 'QrGenerate | Gerador de QR Code Grátis e Guia Completo',
                'description'    => 'Crie QR Codes grátis, sem cadastro e sem guardar os seus dados. O QR Code é gerado directamente no seu navegador.',
                'canonical'      => "{$baseUrl}/pt",
                'og_title'       => 'QrGenerate | Gerador de QR Code Grátis',
                'og_description' => 'Crie QR Codes grátis, sem cadastro e sem guardar os seus dados.',
                'og_image'       => $baseUrl . config('qrgenerate.seo.og_image'),
                'og_type'        => config('qrgenerate.seo.og_type'),
                'hreflang'       => [
                    'en'        => "{$baseUrl}/",
                    'pt'        => "{$baseUrl}/pt",
                    'x-default' => "{$baseUrl}/",
                ],
            ],
        ]);
    }
}
