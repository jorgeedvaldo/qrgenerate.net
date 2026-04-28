<?php

/*
|--------------------------------------------------------------------------
| QR Code SEO Pages — English
|--------------------------------------------------------------------------
| Each entry is keyed by its URL slug. The controller looks up the slug
| here and returns 404 if not found. To add a new page, just add an entry.
*/

return [

    'free-qr-code-generator' => [
        'locale' => 'en',
        'alternate_slug' => 'gerador-de-qr-code-gratis',
        'title' => 'Free QR Code Generator Online — No Cost, No Limits | QrGenerate',
        'meta_description' => 'Generate unlimited QR codes for free. No account required, no watermarks. Create QR codes for URLs, text, Wi-Fi, and more directly in your browser.',
        'h1' => 'Free QR Code Generator',
        'intro' => 'Create high-quality QR codes completely free of charge. QrGenerate runs entirely in your browser — your data never leaves your device. No account, no limits, no watermarks.',
        'qr_type' => 'url',
        'use_cases' => [
            'Generate QR codes for marketing flyers, posters, and business cards.',
            'Create QR codes for product packaging and labels.',
            'Share Wi-Fi credentials, contact details, or event links via QR code.',
        ],
        'steps' => [
            'Enter your URL or text in the input field above.',
            'Optionally upload a logo and choose custom colors.',
            'Click "Generate QR Code" and download the PNG instantly.',
        ],
        'faqs' => [
            ['question' => 'Is QrGenerate really free?', 'answer' => 'Yes, 100% free with no hidden fees. There are no limits on how many QR codes you can generate and no account is required.'],
            ['question' => 'Do my QR codes expire?', 'answer' => 'No. QrGenerate creates static QR codes that encode data directly into the image. They never expire and do not depend on any external server.'],
        ],
        'related_pages' => ['free-qr-code-generator-no-signup', 'private-qr-code-generator', 'qr-code-with-logo'],
    ],

    'free-qr-code-generator-no-signup' => [
        'locale' => 'en',
        'alternate_slug' => 'gerador-de-qr-code-sem-cadastro',
        'title' => 'Free QR Code Generator — No Sign-Up Required | QrGenerate',
        'meta_description' => 'Generate QR codes instantly without creating an account. No sign-up, no email required. 100% browser-based and private.',
        'h1' => 'Free QR Code Generator — No Sign-Up Needed',
        'intro' => 'Skip the registration forms. QrGenerate lets you create unlimited QR codes without signing up. No email address, no password, no personal data collected — ever.',
        'qr_type' => 'url',
        'use_cases' => [
            'Quickly generate a QR code for a one-time event or meeting.',
            'Create codes on shared or public computers without leaving personal data.',
            'Let team members generate QR codes without managing user accounts.',
        ],
        'steps' => [
            'Open QrGenerate — no login screen, no sign-up wall.',
            'Type or paste your URL or text content.',
            'Generate, download, and use your QR code immediately.',
        ],
        'faqs' => [
            ['question' => 'Why don\'t you require sign-up?', 'answer' => 'QrGenerate generates QR codes entirely in your browser. Since no data is sent to a server, there is nothing to associate with an account.'],
            ['question' => 'Can I still customise my QR code without an account?', 'answer' => 'Absolutely. You can change colours, add a logo, and set a print label — all without signing up.'],
        ],
        'related_pages' => ['free-qr-code-generator', 'private-qr-code-generator', 'static-qr-code-generator'],
    ],

    'private-qr-code-generator' => [
        'locale' => 'en',
        'alternate_slug' => 'gerador-de-qr-code-privado',
        'title' => 'Private QR Code Generator — Your Data Stays on Your Device | QrGenerate',
        'meta_description' => 'Generate QR codes with complete privacy. QrGenerate processes everything in your browser — no data is uploaded, stored, or tracked.',
        'h1' => 'Private QR Code Generator',
        'intro' => 'Your privacy matters. QrGenerate processes everything client-side using JavaScript. Your URLs, texts, logos, and generated images never leave your device. No cookies, no tracking, no analytics on your content.',
        'qr_type' => 'url',
        'use_cases' => [
            'Generate QR codes for confidential internal documents and links.',
            'Create codes containing sensitive Wi-Fi passwords without server exposure.',
            'Produce QR codes for medical or legal URLs that must remain private.',
        ],
        'steps' => [
            'Enter your private URL or text — it stays in your browser.',
            'Add branding with a logo if needed.',
            'Download the QR code — nothing is stored on our servers.',
        ],
        'faqs' => [
            ['question' => 'Is my data really private?', 'answer' => 'Yes. QrGenerate uses client-side JavaScript exclusively. Your content is processed in your browser and never transmitted to any server.'],
            ['question' => 'Do you use cookies or trackers?', 'answer' => 'We use Google Analytics for page-view statistics only. Your QR code content is never tracked or stored.'],
        ],
        'related_pages' => ['free-qr-code-generator-no-signup', 'free-qr-code-generator', 'qr-code-for-wifi'],
    ],

    'static-qr-code-generator' => [
        'locale' => 'en',
        'alternate_slug' => null,
        'title' => 'Static QR Code Generator — Permanent Codes That Never Expire | QrGenerate',
        'meta_description' => 'Create static QR codes that work forever without any subscription. Data is encoded directly into the QR pattern — no server dependency.',
        'h1' => 'Static QR Code Generator',
        'intro' => 'Static QR codes embed your data directly into the pattern. They never expire, never require a subscription, and never depend on a third-party server. Perfect for print materials, signage, and packaging.',
        'qr_type' => 'url',
        'use_cases' => [
            'Print permanent QR codes on business cards, menus, or product labels.',
            'Create signage QR codes that work for years without renewal.',
            'Encode Wi-Fi passwords or contact info that never needs server uptime.',
        ],
        'steps' => [
            'Enter the final destination URL or content.',
            'Customise the appearance with your brand colours.',
            'Download and print — your code works forever.',
        ],
        'faqs' => [
            ['question' => 'What is a static QR code?', 'answer' => 'A static QR code encodes data directly into its visual pattern. The destination URL or text is permanently embedded and cannot be changed after creation.'],
            ['question' => 'Can I update a static QR code later?', 'answer' => 'No — that is the trade-off. If you need to change the destination, you must generate a new code. For updatable codes, consider a dynamic QR service.'],
        ],
        'related_pages' => ['dynamic-qr-code-vs-static-qr-code', 'free-qr-code-generator', 'private-qr-code-generator'],
    ],

    'dynamic-qr-code-vs-static-qr-code' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-estatico-vs-dinamico',
        'title' => 'Dynamic vs Static QR Code — Key Differences Explained | QrGenerate',
        'meta_description' => 'Understand the difference between dynamic and static QR codes. Learn when to use each type and why static codes offer better privacy and permanence.',
        'h1' => 'Dynamic QR Code vs Static QR Code',
        'intro' => 'Choosing between dynamic and static QR codes? Static codes are free, permanent, and private — they encode data directly into the image. Dynamic codes use a redirect URL that can be updated later but depend on a third-party service staying online.',
        'qr_type' => 'url',
        'use_cases' => [
            'Choose static for permanent signage, packaging, and business cards.',
            'Choose dynamic for marketing campaigns where the destination may change.',
            'Use static for privacy-sensitive content like Wi-Fi credentials or medical links.',
        ],
        'steps' => [
            'Decide if your destination URL will ever need to change.',
            'If permanent, use QrGenerate to create a free static QR code.',
            'If you need tracking or URL changes, consider a paid dynamic QR service.',
        ],
        'faqs' => [
            ['question' => 'Which type does QrGenerate create?', 'answer' => 'QrGenerate creates static QR codes. Your data is encoded directly into the QR image with no server dependency, no expiration, and no fees.'],
            ['question' => 'Are dynamic QR codes better?', 'answer' => 'Not necessarily. Dynamic codes offer flexibility but require a subscription and depend on a third-party server. Static codes are free, permanent, and fully private.'],
        ],
        'related_pages' => ['static-qr-code-generator', 'free-qr-code-generator', 'private-qr-code-generator'],
    ],

    'qr-code-for-whatsapp' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-para-whatsapp',
        'title' => 'QR Code for WhatsApp — Generate a Chat Link QR | QrGenerate',
        'meta_description' => 'Create a QR code that opens a WhatsApp chat with a pre-filled message. Free, no sign-up, instant download.',
        'h1' => 'QR Code for WhatsApp',
        'intro' => 'Generate a QR code that opens a WhatsApp conversation instantly. Use the format <code>https://wa.me/PHONENUMBER?text=MESSAGE</code> to pre-fill both the recipient and the message. Perfect for customer support, event RSVPs, and quick contact sharing.',
        'qr_type' => 'url',
        'use_cases' => [
            'Add a WhatsApp QR code to your business card or storefront.',
            'Print a "Chat with us" QR on restaurant tables or receipts.',
            'Share a pre-filled order message link at events or markets.',
        ],
        'steps' => [
            'Build your WhatsApp link: https://wa.me/1234567890?text=Hello',
            'Paste the link into the generator above.',
            'Generate and download your QR code.',
        ],
        'faqs' => [
            ['question' => 'What format should I use?', 'answer' => 'Use <code>https://wa.me/COUNTRYCODE+NUMBER?text=YOUR+MESSAGE</code>. Replace spaces with + signs in the message.'],
            ['question' => 'Does the recipient need to have my number saved?', 'answer' => 'No. The wa.me link works even if the scanner does not have your number in their contacts.'],
        ],
        'related_pages' => ['qr-code-for-sms', 'qr-code-for-email', 'qr-code-for-instagram'],
    ],

    'qr-code-for-wifi' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-para-wifi',
        'title' => 'QR Code for Wi-Fi — Share Your Network Instantly | QrGenerate',
        'meta_description' => 'Create a QR code that connects smartphones to your Wi-Fi network automatically. No typing passwords. Free and private.',
        'h1' => 'QR Code for Wi-Fi',
        'intro' => 'Let guests connect to your Wi-Fi in one scan. Use the format <code>WIFI:T:WPA;S:YourSSID;P:YourPassword;;</code> to encode your network credentials. The scanner\'s phone will auto-join the network.',
        'qr_type' => 'url',
        'use_cases' => [
            'Display a Wi-Fi QR code in hotel rooms, cafés, or co-working spaces.',
            'Print Wi-Fi access codes on Airbnb welcome guides.',
            'Share home Wi-Fi with visitors without dictating the password.',
        ],
        'steps' => [
            'Format your Wi-Fi string: WIFI:T:WPA;S:MyNetwork;P:MyPassword;;',
            'Paste it into the generator above.',
            'Print the QR code and place it near your router or entrance.',
        ],
        'faqs' => [
            ['question' => 'What security types are supported?', 'answer' => 'Use <code>WPA</code> for WPA/WPA2/WPA3, <code>WEP</code> for WEP, or leave empty for open networks: <code>WIFI:T:;S:Name;P:;;</code>'],
            ['question' => 'Will this work on iPhone and Android?', 'answer' => 'Yes. Both iOS (11+) and Android natively support Wi-Fi QR codes through the built-in camera app.'],
        ],
        'related_pages' => ['private-qr-code-generator', 'qr-code-for-location', 'free-qr-code-generator'],
    ],

    'qr-code-with-logo' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-com-logotipo',
        'title' => 'QR Code with Logo — Add Your Brand to Any QR Code | QrGenerate',
        'meta_description' => 'Generate custom QR codes with your logo in the center. Free, high-quality, and scannable. Upload PNG or JPG logos instantly.',
        'h1' => 'QR Code with Logo',
        'intro' => 'Make your QR codes recognisable. Upload your logo (PNG or JPG) and QrGenerate will embed it in the centre of your code. We use Error Correction Level H (30%) so the code remains fully scannable even with the logo overlay.',
        'qr_type' => 'url',
        'use_cases' => [
            'Brand your QR codes on marketing materials, packaging, and menus.',
            'Add your company logo to event tickets and conference badges.',
            'Create professional-looking QR codes for client presentations.',
        ],
        'steps' => [
            'Enter your URL or content in the input field.',
            'Click "Upload Logo" and select your PNG or JPG image.',
            'Generate the QR code — your logo appears centred automatically.',
        ],
        'faqs' => [
            ['question' => 'Will the logo make the QR code unscannable?', 'answer' => 'No. QrGenerate uses the highest error correction level (H), which allows up to 30% of the code to be covered while remaining scannable.'],
            ['question' => 'What logo size works best?', 'answer' => 'Keep your logo under 25% of the QR code area. Square logos between 60×60 and 80×80 pixels work best.'],
        ],
        'related_pages' => ['free-qr-code-generator', 'qr-code-for-business-card', 'qr-code-for-instagram'],
    ],

    'qr-code-for-business-card' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-para-cartao-de-visita',
        'title' => 'QR Code for Business Card — Share Contact Info Instantly | QrGenerate',
        'meta_description' => 'Create a vCard QR code for your business card. One scan saves your name, phone, email, and website to the contact list.',
        'h1' => 'QR Code for Business Card',
        'intro' => 'Add a QR code to your business card that saves your full contact details in one scan. Encode a vCard string with your name, phone, email, company, title, and website. The scanner\'s phone will offer to save you as a contact instantly.',
        'qr_type' => 'url',
        'use_cases' => [
            'Print a vCard QR code on the back of your business card.',
            'Add a contact QR to your email signature or LinkedIn profile.',
            'Display a large contact QR code at trade show booths.',
        ],
        'steps' => [
            'Build your vCard string (see format below) or paste a vCard URL.',
            'Enter it in the generator and optionally add your company logo.',
            'Download and add to your business card design.',
        ],
        'faqs' => [
            ['question' => 'What is the vCard format?', 'answer' => 'A vCard starts with BEGIN:VCARD and ends with END:VCARD. It contains fields like FN (full name), TEL (phone), EMAIL, ORG (company), TITLE, and URL.'],
            ['question' => 'How much data can a vCard QR code hold?', 'answer' => 'A QR code can hold up to ~4,000 characters. A typical vCard uses 200-400 characters, which fits comfortably.'],
        ],
        'related_pages' => ['qr-code-for-email', 'qr-code-with-logo', 'qr-code-for-whatsapp'],
    ],

    'qr-code-for-restaurant-menu' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-para-menu-de-restaurante',
        'title' => 'QR Code for Restaurant Menu — Contactless Digital Menus | QrGenerate',
        'meta_description' => 'Generate a QR code that links to your digital restaurant menu. Contactless, always up to date, and free to create.',
        'h1' => 'QR Code for Restaurant Menu',
        'intro' => 'Replace paper menus with a scannable QR code. Link to your digital menu hosted on your website, Google Drive, or a PDF. Update your menu anytime without reprinting QR codes by keeping the same URL.',
        'qr_type' => 'url',
        'use_cases' => [
            'Place QR codes on every table for contactless ordering.',
            'Add menu QR codes to your storefront window or takeaway bags.',
            'Print QR codes on table tents, coasters, or receipts.',
        ],
        'steps' => [
            'Upload your menu as a PDF or create a web page for it.',
            'Paste the menu URL into the generator above.',
            'Print the QR code on table stands or stickers.',
        ],
        'faqs' => [
            ['question' => 'Can I update my menu without changing the QR code?', 'answer' => 'Yes — if you keep the same URL and update the content behind it (e.g., replace the PDF file at the same link), the existing QR code will always point to the latest version.'],
            ['question' => 'What is the best format for a digital menu?', 'answer' => 'A mobile-friendly web page is ideal. A PDF works too but loads slower on phones. Avoid images-only menus as they are not accessible.'],
        ],
        'related_pages' => ['qr-code-for-wifi', 'qr-code-for-location', 'free-qr-code-generator'],
    ],

    'qr-code-for-instagram' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-para-instagram',
        'title' => 'QR Code for Instagram — Link to Your Profile | QrGenerate',
        'meta_description' => 'Create a QR code that opens your Instagram profile directly. Add it to business cards, flyers, or packaging.',
        'h1' => 'QR Code for Instagram',
        'intro' => 'Drive followers to your Instagram profile with a scannable QR code. Simply enter your profile URL (<code>https://instagram.com/yourname</code>) and generate a branded code you can add to any print or digital material.',
        'qr_type' => 'url',
        'use_cases' => [
            'Add an Instagram QR to product packaging or shopping bags.',
            'Print profile QR codes on business cards and event banners.',
            'Display your Instagram QR at the checkout counter or reception.',
        ],
        'steps' => [
            'Copy your Instagram profile URL: https://instagram.com/yourname',
            'Paste it in the generator and upload your profile picture as logo.',
            'Download and use on your marketing materials.',
        ],
        'faqs' => [
            ['question' => 'Can I link to a specific Instagram post?', 'answer' => 'Yes. Just paste the URL of the individual post instead of your profile URL. The QR code will open that specific post.'],
            ['question' => 'Should I use my Instagram Nametag instead?', 'answer' => 'Instagram Nametags have been discontinued. A standard QR code linking to your profile URL is now the recommended approach.'],
        ],
        'related_pages' => ['qr-code-for-whatsapp', 'qr-code-with-logo', 'qr-code-for-business-card'],
    ],

    'qr-code-for-pdf' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-para-pdf',
        'title' => 'QR Code for PDF — Link to Any Document | QrGenerate',
        'meta_description' => 'Generate a QR code that opens a PDF document. Share menus, brochures, manuals, or price lists with a single scan.',
        'h1' => 'QR Code for PDF',
        'intro' => 'Share any PDF document via a QR code. Upload your PDF to a hosting service (Google Drive, Dropbox, or your own website) and paste the direct link into QrGenerate. Scanners will open the PDF instantly on their phone.',
        'qr_type' => 'url',
        'use_cases' => [
            'Link printed brochures to their full digital PDF version.',
            'Share instruction manuals or spec sheets on product packaging.',
            'Distribute event programmes, conference agendas, or price lists.',
        ],
        'steps' => [
            'Upload your PDF to Google Drive, Dropbox, or your website.',
            'Get the public sharing link and paste it in the generator.',
            'Generate and print the QR code alongside your printed material.',
        ],
        'faqs' => [
            ['question' => 'Where should I host my PDF?', 'answer' => 'Google Drive (with "Anyone with the link" sharing) is free and reliable. Your own website or a CDN offers faster loading.'],
            ['question' => 'Can I update the PDF without changing the QR code?', 'answer' => 'Yes — if you replace the file at the same URL (e.g., replace the file in Google Drive), the QR code will always point to the latest version.'],
        ],
        'related_pages' => ['qr-code-for-restaurant-menu', 'free-qr-code-generator', 'qr-code-with-logo'],
    ],

    'qr-code-for-location' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-para-localizacao',
        'title' => 'QR Code for Location — Open Google Maps Instantly | QrGenerate',
        'meta_description' => 'Create a QR code that opens a specific location on Google Maps. Perfect for event invitations, business cards, and signage.',
        'h1' => 'QR Code for Location',
        'intro' => 'Help people find you. Create a QR code that opens a precise location on Google Maps or any map app. Use a Google Maps share link or geo-coordinates in the format <code>geo:LAT,LNG</code>.',
        'qr_type' => 'url',
        'use_cases' => [
            'Add a location QR code to wedding or event invitations.',
            'Print directions QR codes on business cards or letterheads.',
            'Display a "Find us" QR code on your storefront window.',
        ],
        'steps' => [
            'Open Google Maps, find your location, and click "Share" to get the link.',
            'Paste the Google Maps link into the generator above.',
            'Download the QR code and add it to your invitation or signage.',
        ],
        'faqs' => [
            ['question' => 'What link format should I use?', 'answer' => 'The simplest option is a Google Maps share link (https://maps.google.com/?q=...). You can also use the geo: URI format for cross-platform compatibility.'],
            ['question' => 'Will it work with Apple Maps?', 'answer' => 'A Google Maps link will open in Google Maps on Android and offer to open in Apple Maps on iPhone. The geo: format opens the device default map app.'],
        ],
        'related_pages' => ['qr-code-for-restaurant-menu', 'qr-code-for-business-card', 'qr-code-for-whatsapp'],
    ],

    'qr-code-for-email' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-para-email',
        'title' => 'QR Code for Email — Pre-Fill Address, Subject & Body | QrGenerate',
        'meta_description' => 'Generate a QR code that opens a pre-filled email. Set the recipient, subject line, and body text automatically.',
        'h1' => 'QR Code for Email',
        'intro' => 'Make it easy for people to email you. Create a QR code using the <code>mailto:</code> format that pre-fills the recipient address, subject line, and body text. One scan opens the email app ready to send.',
        'qr_type' => 'url',
        'use_cases' => [
            'Add a "Contact us" QR code to printed marketing materials.',
            'Pre-fill feedback or support request emails on product packaging.',
            'Include a quick-email QR code on conference name badges.',
        ],
        'steps' => [
            'Build your mailto link: mailto:you@example.com?subject=Hello&body=Message',
            'Paste it in the generator above.',
            'Download and print your email QR code.',
        ],
        'faqs' => [
            ['question' => 'What is the mailto format?', 'answer' => 'Use <code>mailto:email@example.com?subject=Your+Subject&body=Your+Message</code>. Replace spaces with + signs.'],
            ['question' => 'Does it work on all phones?', 'answer' => 'Yes. The mailto: protocol is supported by all modern smartphones and opens the default email app.'],
        ],
        'related_pages' => ['qr-code-for-sms', 'qr-code-for-whatsapp', 'qr-code-for-business-card'],
    ],

    'qr-code-for-sms' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-para-sms',
        'title' => 'QR Code for SMS — Pre-Fill a Text Message | QrGenerate',
        'meta_description' => 'Create a QR code that opens a pre-filled SMS message. Set the phone number and message text automatically.',
        'h1' => 'QR Code for SMS',
        'intro' => 'Generate a QR code that opens the messaging app with a pre-filled phone number and text. Use the format <code>sms:+1234567890?body=Your+Message</code> or <code>SMSTO:+1234567890:Your Message</code>.',
        'qr_type' => 'url',
        'use_cases' => [
            'Create opt-in QR codes for SMS marketing campaigns.',
            'Add a "Text us" QR code to business cards or storefront signs.',
            'Pre-fill support request messages on product labels.',
        ],
        'steps' => [
            'Build your SMS link: sms:+1234567890?body=Hello',
            'Paste it in the generator above.',
            'Generate and download your SMS QR code.',
        ],
        'faqs' => [
            ['question' => 'What SMS format works best?', 'answer' => 'Use <code>sms:+COUNTRYCODENUMBER?body=Message</code> for iOS and <code>SMSTO:+NUMBER:Message</code> for broader compatibility. The sms: format works on most modern phones.'],
            ['question' => 'Can I send the SMS automatically?', 'answer' => 'No. For security reasons, scanning a QR code only pre-fills the message. The user must tap "Send" manually.'],
        ],
        'related_pages' => ['qr-code-for-whatsapp', 'qr-code-for-email', 'free-qr-code-generator'],
    ],

];
