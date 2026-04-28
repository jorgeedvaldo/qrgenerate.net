<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function privacy()
    {
        return view('pages.institutional.privacy', [
            'locale' => 'en',
            'seo' => [
                'title' => 'Privacy Policy | QrGenerate',
                'description' => 'Read the QrGenerate privacy policy. Learn how our browser-based QR code generator protects your data by keeping it on your device.',
                'canonical' => url('/privacy-policy'),
                'hreflang' => [
                    'en' => url('/privacy-policy'),
                    'pt' => url('/pt/politica-de-privacidade'),
                    'x-default' => url('/privacy-policy'),
                ],
            ]
        ]);
    }

    public function privacyPt()
    {
        return view('pages.institutional.privacy-pt', [
            'locale' => 'pt',
            'seo' => [
                'title' => 'Política de Privacidade | QrGenerate',
                'description' => 'Leia a política de privacidade do QrGenerate. Saiba como o nosso gerador de QR Code no navegador protege os seus dados.',
                'canonical' => url('/pt/politica-de-privacidade'),
                'hreflang' => [
                    'pt' => url('/pt/politica-de-privacidade'),
                    'en' => url('/privacy-policy'),
                    'x-default' => url('/privacy-policy'),
                ],
            ]
        ]);
    }

    public function terms()
    {
        return view('pages.institutional.terms', [
            'locale' => 'en',
            'seo' => [
                'title' => 'Terms of Use | QrGenerate',
                'description' => 'Terms of use for QrGenerate. Please read these terms carefully before using our free QR code generator.',
                'canonical' => url('/terms-of-use'),
                'hreflang' => [
                    'en' => url('/terms-of-use'),
                    'pt' => url('/pt/termos-de-uso'),
                    'x-default' => url('/terms-of-use'),
                ],
            ]
        ]);
    }

    public function termsPt()
    {
        return view('pages.institutional.terms-pt', [
            'locale' => 'pt',
            'seo' => [
                'title' => 'Termos de Uso | QrGenerate',
                'description' => 'Termos de uso do QrGenerate. Por favor, leia com atenção antes de usar o nosso gerador de QR Code gratuito.',
                'canonical' => url('/pt/termos-de-uso'),
                'hreflang' => [
                    'pt' => url('/pt/termos-de-uso'),
                    'en' => url('/terms-of-use'),
                    'x-default' => url('/terms-of-use'),
                ],
            ]
        ]);
    }

    public function about()
    {
        return view('pages.institutional.about', [
            'locale' => 'en',
            'seo' => [
                'title' => 'About Us | QrGenerate',
                'description' => 'Learn more about QrGenerate. Our mission is to provide a fast, private, and free QR code generator for everyone.',
                'canonical' => url('/about'),
                'hreflang' => [
                    'en' => url('/about'),
                    'pt' => url('/pt/sobre'),
                    'x-default' => url('/about'),
                ],
            ]
        ]);
    }

    public function aboutPt()
    {
        return view('pages.institutional.about-pt', [
            'locale' => 'pt',
            'seo' => [
                'title' => 'Sobre Nós | QrGenerate',
                'description' => 'Saiba mais sobre o QrGenerate. A nossa missão é fornecer um gerador de QR Code rápido, privado e gratuito para todos.',
                'canonical' => url('/pt/sobre'),
                'hreflang' => [
                    'pt' => url('/pt/sobre'),
                    'en' => url('/about'),
                    'x-default' => url('/about'),
                ],
            ]
        ]);
    }

    public function contact()
    {
        return view('pages.institutional.contact', [
            'locale' => 'en',
            'seo' => [
                'title' => 'Contact Us | QrGenerate',
                'description' => 'Get in touch with the QrGenerate team for feedback, support, or general inquiries.',
                'canonical' => url('/contact'),
                'hreflang' => [
                    'en' => url('/contact'),
                    'pt' => url('/pt/contacto'),
                    'x-default' => url('/contact'),
                ],
            ]
        ]);
    }

    public function contactPt()
    {
        return view('pages.institutional.contact-pt', [
            'locale' => 'pt',
            'seo' => [
                'title' => 'Contacto | QrGenerate',
                'description' => 'Entre em contacto com a equipa do QrGenerate para feedback, suporte ou dúvidas gerais.',
                'canonical' => url('/pt/contacto'),
                'hreflang' => [
                    'pt' => url('/pt/contacto'),
                    'en' => url('/contact'),
                    'x-default' => url('/contact'),
                ],
            ]
        ]);
    }
}
