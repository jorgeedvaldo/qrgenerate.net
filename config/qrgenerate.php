<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Identity
    |--------------------------------------------------------------------------
    */

    'name'    => env('APP_NAME', 'QrGenerate'),
    'url'     => env('APP_URL', 'https://qrgenerate.net'),
    'slogan'  => '100% Free. No Servers. Maximum Privacy.',

    /*
    |--------------------------------------------------------------------------
    | Default SEO Metadata
    |--------------------------------------------------------------------------
    | Fallback values used when a page does not define its own meta tags.
    */

    'seo' => [
        'title'       => 'QrGenerate | Free QR Code Generator & The Complete Guide to QR Codes',
        'description' => 'Learn how QR codes work, design best practices, and generate your own custom, secure, client-side QR codes with logos and colors for free.',
        'keywords'    => 'QR code guide, how QR codes work, custom QR code generator, client-side QR code, QR with logo, print QR code, QrGenerate',
        'author'      => 'QrGenerate Team',
        'og_image'    => '/images/qrgenerate-cover.jpg',
        'og_type'     => 'website',
        'twitter_card' => 'summary_large_image',
    ],

    /*
    |--------------------------------------------------------------------------
    | Google Analytics
    |--------------------------------------------------------------------------
    */

    'analytics_id' => env('QRGENERATE_GA_ID', 'G-CGVGCES8DF'),

    /*
    |--------------------------------------------------------------------------
    | Available Languages
    |--------------------------------------------------------------------------
    | Languages supported by the site. The first entry is the default.
    */

    'languages' => [
        'en' => 'English',
        'pt' => 'Português',
        'es' => 'Español',
        'fr' => 'Français',
    ],

    /*
    |--------------------------------------------------------------------------
    | QR Code Types
    |--------------------------------------------------------------------------
    | Initial list of QR code types the site can generate / document.
    | Each entry contains a slug (for URL), label, icon, and description.
    */

    'qr_types' => [
        [
            'slug'        => 'url',
            'label'       => 'URL / Website',
            'icon'        => 'glyphicon-globe',
            'description' => 'Link directly to any web page.',
        ],
        [
            'slug'        => 'text',
            'label'       => 'Plain Text',
            'icon'        => 'glyphicon-font',
            'description' => 'Encode any plain text message.',
        ],
        [
            'slug'        => 'email',
            'label'       => 'Email',
            'icon'        => 'glyphicon-envelope',
            'description' => 'Pre-fill an email address, subject, and body.',
        ],
        [
            'slug'        => 'phone',
            'label'       => 'Phone Number',
            'icon'        => 'glyphicon-phone',
            'description' => 'Dial a phone number with one scan.',
        ],
        [
            'slug'        => 'sms',
            'label'       => 'SMS',
            'icon'        => 'glyphicon-comment',
            'description' => 'Open a pre-filled SMS message.',
        ],
        [
            'slug'        => 'wifi',
            'label'       => 'Wi-Fi',
            'icon'        => 'glyphicon-signal',
            'description' => 'Connect to a Wi-Fi network instantly.',
        ],
        [
            'slug'        => 'vcard',
            'label'       => 'vCard / Contact',
            'icon'        => 'glyphicon-user',
            'description' => 'Share a digital business card.',
        ],
        [
            'slug'        => 'geo',
            'label'       => 'Location',
            'icon'        => 'glyphicon-map-marker',
            'description' => 'Open a map location directly.',
        ],
    ],

];
