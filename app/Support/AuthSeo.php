<?php

namespace App\Support;

/**
 * Shared SEO metadata for the account pages. These pages are noindex —
 * they exist for users, not for search engines.
 */
class AuthSeo
{
    private const PATHS = [
        'login'          => ['en' => '/login', 'pt' => '/pt/entrar'],
        'register'       => ['en' => '/register', 'pt' => '/pt/criar-conta'],
        'forgot'         => ['en' => '/forgot-password', 'pt' => '/pt/recuperar-senha'],
        'reset'          => ['en' => '/reset-password', 'pt' => '/pt/redefinir-senha'],
    ];

    private const TITLES = [
        'login'    => ['en' => 'Sign In | QRGenerate', 'pt' => 'Entrar | QRGenerate'],
        'register' => ['en' => 'Create Your Free Account | QRGenerate', 'pt' => 'Criar Conta Grátis | QRGenerate'],
        'forgot'   => ['en' => 'Reset Your Password | QRGenerate', 'pt' => 'Recuperar Senha | QRGenerate'],
        'reset'    => ['en' => 'Choose a New Password | QRGenerate', 'pt' => 'Definir Nova Senha | QRGenerate'],
    ];

    public static function for(string $page, string $locale): array
    {
        $baseUrl = config('qrgenerate.url');
        $path = self::PATHS[$page][$locale] ?? '/login';

        return [
            'title'       => self::TITLES[$page][$locale] ?? 'QRGenerate',
            'description' => $locale === 'pt'
                ? 'Acesse sua conta QRGenerate para criar e gerir os seus convites digitais.'
                : 'Access your QRGenerate account to create and manage your digital invitations.',
            'canonical'   => $baseUrl . $path,
            'robots'      => 'noindex, follow',
        ];
    }
}
