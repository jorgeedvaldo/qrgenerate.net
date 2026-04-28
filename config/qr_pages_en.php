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
        'title' => 'Free QR Code Generator | Create Custom QR Codes No Signup',
        'meta_description' => 'Generate unlimited, permanent QR codes for free. No account required, no tracking. Create custom QR codes for URLs, text, and more directly in your browser.',
        'h1' => 'Free QR Code Generator',
        'intro' => 'Create high-quality, static QR codes completely free of charge. QrGenerate runs entirely in your browser — your data never leaves your device. No account, no limits, no watermarks, and they never expire.',
        'qr_type' => 'url',
        'use_cases' => [
            'Generate QR codes for marketing flyers, posters, and business cards.',
            'Create permanent QR codes for product packaging and labels.',
            'Share quick links to your website or portfolio without any scan limits.',
        ],
        'steps' => [
            'Enter your URL or text in the input field above.',
            'Optionally upload a logo and choose custom colors.',
            'Click "Generate QR Code" and download the PNG instantly.',
        ],
        'faqs' => [
            ['question' => 'Is this QR code generator really free?', 'answer' => 'Yes, it is 100% free. There are no hidden fees, no scan limits, and you do not need to create an account to download your QR code.'],
            ['question' => 'Will my QR code expire?', 'answer' => 'No. We generate static QR codes, which means the data is encoded directly into the image itself. They will work forever.'],
            ['question' => 'Are there any scan limits?', 'answer' => 'There are absolutely no scan limits. Your QR code will continue to work regardless of how many times it is scanned.'],
            ['question' => 'Can I use the generated QR code for commercial purposes?', 'answer' => 'Yes, you have full rights to use the generated QR codes for commercial materials, marketing campaigns, and print media.'],
            ['question' => 'Do you track who scans the QR code?', 'answer' => 'No. Static QR codes do not route traffic through our servers, meaning we have no way to track or collect data on who scans your codes.'],
        ],
        'related_pages' => ['private-qr-code-generator', 'static-qr-code-generator', 'qr-code-with-logo', 'qr-code-for-wifi', 'qr-code-for-whatsapp'],
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
        'related_pages' => ['free-qr-code-generator', 'private-qr-code-generator', 'static-qr-code-generator', 'qr-code-for-wifi', 'qr-code-for-business-card'],
    ],

    'private-qr-code-generator' => [
        'locale' => 'en',
        'alternate_slug' => 'gerador-de-qr-code-privado',
        'title' => 'Private QR Code Generator | No Server Tracking, 100% Secure',
        'meta_description' => 'Generate QR codes privately in your browser. No data is sent to our servers, no tracking, and no logs. The most secure way to create QR codes.',
        'h1' => 'Private QR Code Generator',
        'intro' => 'Security matters. QrGenerate is built with privacy by design. Our tool uses client-side JavaScript to render your QR codes directly inside your web browser. We never see, transmit, or store your sensitive data.',
        'qr_type' => 'url',
        'use_cases' => [
            'Generating QR codes for sensitive internal company URLs.',
            'Creating Wi-Fi QR codes for private home networks.',
            'Encoding personal contact information without third-party logging.',
        ],
        'steps' => [
            'Disconnect from the internet if you want to be extra safe (our site works offline once loaded!).',
            'Enter your sensitive data into the generator.',
            'Download the generated image.',
            'Close the tab. No traces are left behind.'
        ],
        'faqs' => [
            ['question' => 'How does local processing work?', 'answer' => 'When you type into the generator, a script running on your own computer calculates the QR code image. The data never travels over the internet.'],
            ['question' => 'Do you keep logs of my QR codes?', 'answer' => 'No. Because the data never reaches our servers, we have zero logs of what you generate.'],
            ['question' => 'Can I generate QR codes offline?', 'answer' => 'Yes! Once you load the QrGenerate webpage, you can disconnect your Wi-Fi, and the generator will continue to work perfectly.'],
            ['question' => 'Are your QR codes dynamic or static?', 'answer' => 'They are static. Dynamic QR codes require routing through a server, which compromises privacy. Static codes ensure your data remains directly in the image.'],
            ['question' => 'Why do other sites require signups?', 'answer' => 'Many sites want to collect your email for marketing or force you into a paid subscription to keep your QR codes active. We do neither.'],
        ],
        'related_pages' => ['static-qr-code-generator', 'free-qr-code-generator', 'qr-code-for-wifi', 'qr-code-for-business-card', 'qr-code-with-logo'],
    ],

    'static-qr-code-generator' => [
        'locale' => 'en',
        'alternate_slug' => null,
        'title' => 'Static QR Code Generator | Permanent, No Expiration Codes',
        'meta_description' => 'Create static QR codes that never expire. Completely free, no scan limits, and no subscriptions. Generate permanent QR codes for your business today.',
        'h1' => 'Static QR Code Generator',
        'intro' => 'Static QR codes encode your data directly into the black and white squares of the image. They don\'t rely on external servers to redirect traffic, which means they are faster, more private, and most importantly—they never expire.',
        'qr_type' => 'url',
        'use_cases' => [
            'Books, manuals, and permanent print materials.',
            'Engraved plaques and permanent signage.',
            'One-time offline data transfer (like Wi-Fi passwords).',
        ],
        'steps' => [
            'Enter the data you want to embed permanently.',
            'Customize your code (note: longer text makes denser QR codes).',
            'Download your high-resolution PNG or SVG file.',
            'Distribute your code with peace of mind.'
        ],
        'faqs' => [
            ['question' => 'What is the difference between Static and Dynamic QR Codes?', 'answer' => 'Static codes hold the actual data (like a URL) inside the image. Dynamic codes hold a short link that redirects to your URL. If the provider goes out of business, dynamic codes break. Static codes work forever.'],
            ['question' => 'Can I edit a static QR code later?', 'answer' => 'No. Because the data is baked into the image pattern, changing the data requires generating a completely new QR code.'],
            ['question' => 'Will a static QR code ever expire?', 'answer' => 'Never. As long as the destination URL is still alive (or the text is still relevant), the QR code will function indefinitely.'],
            ['question' => 'Is there a limit to how much data a static code can hold?', 'answer' => 'Yes. While they can hold a few thousand characters, adding too much text makes the code very dense and harder for cheap cameras to scan.'],
            ['question' => 'Are static codes free?', 'answer' => 'On QrGenerate, yes! We do not charge for static codes, and we place no limits on how many times they can be scanned.'],
        ],
        'related_pages' => ['private-qr-code-generator', 'free-qr-code-generator', 'qr-code-for-wifi', 'qr-code-with-logo', 'qr-code-for-whatsapp'],
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
        'related_pages' => ['static-qr-code-generator', 'free-qr-code-generator', 'private-qr-code-generator', 'qr-code-for-restaurant-menu', 'qr-code-with-logo'],
    ],

    'qr-code-for-whatsapp' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-para-whatsapp',
        'title' => 'WhatsApp QR Code Generator | Free Click-to-Chat QR Codes',
        'meta_description' => 'Create a free WhatsApp QR Code. Allow customers to message you instantly without saving your phone number. 100% private and generated in your browser.',
        'h1' => 'QR Code for WhatsApp',
        'intro' => 'Make it effortless for customers to contact you. Generate a free WhatsApp QR code with a pre-filled message. When someone scans it, their WhatsApp app will open directly to a chat with your number, without needing to save you to their contacts.',
        'qr_type' => 'whatsapp',
        'use_cases' => [
            'Customer support desks and service counters.',
            'Real estate "Contact Agent" signs.',
            'Restaurant tables for quick orders or feedback.',
        ],
        'steps' => [
            'Select your country code and enter your WhatsApp phone number.',
            'Type an optional pre-filled message for your customers to send you.',
            'Customize your QR code colors and add a WhatsApp logo.',
            'Download and print your permanent QR code.'
        ],
        'faqs' => [
            ['question' => 'Does the user need to save my number first?', 'answer' => 'No. Scanning the QR code uses the official WhatsApp "Click to Chat" feature, which bypasses the need to save the contact.'],
            ['question' => 'Can I add a default message?', 'answer' => 'Yes, you can pre-fill a message (e.g., "Hi, I need help with an order"). The user can edit it before hitting send.'],
            ['question' => 'Is this safe for my privacy?', 'answer' => 'Your phone number is encoded directly into the QR image. We do not store your number or the messages on our servers.'],
            ['question' => 'Does it work on both iOS and Android?', 'answer' => 'Yes, scanning the code will automatically open the WhatsApp application on any compatible smartphone.'],
            ['question' => 'Will this QR code expire if I change my WhatsApp plan?', 'answer' => 'No, the QR code is static and will work as long as your phone number remains active on WhatsApp.'],
        ],
        'related_pages' => ['qr-code-for-business-card', 'qr-code-for-wifi', 'qr-code-with-logo', 'free-qr-code-generator', 'static-qr-code-generator'],
    ],

    'qr-code-for-wifi' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-para-wifi',
        'title' => 'Wi-Fi QR Code Generator | Connect to Wi-Fi Instantly',
        'meta_description' => 'Generate a free Wi-Fi QR Code to let guests connect to your network instantly without typing passwords. Private, secure, and no signup required.',
        'h1' => 'QR Code for Wi-Fi',
        'intro' => 'Stop spelling out your long Wi-Fi passwords. Generate a secure Wi-Fi QR code that lets guests, customers, or friends connect to your network instantly just by scanning it with their smartphone camera.',
        'qr_type' => 'wifi',
        'use_cases' => [
            'Coffee shops, restaurants, and bars offering guest Wi-Fi.',
            'Airbnb hosts sharing network access with guests.',
            'Offices providing temporary internet access to visitors.',
        ],
        'steps' => [
            'Enter your Network Name (SSID) exactly as it appears on your devices.',
            'Enter your Wi-Fi password (case-sensitive).',
            'Select your network encryption type (WPA/WPA2 is the most common).',
            'Generate, download, and print your Wi-Fi QR code.'
        ],
        'faqs' => [
            ['question' => 'Are my Wi-Fi credentials safe?', 'answer' => 'Yes. QrGenerate processes your Wi-Fi name and password entirely in your browser. We never send or save your credentials on our servers.'],
            ['question' => 'Does this work on iPhones?', 'answer' => 'Yes, the native camera app on iOS 11 and later supports scanning Wi-Fi QR codes to join networks automatically.'],
            ['question' => 'Does this work on Android?', 'answer' => 'Yes, most modern Android devices support Wi-Fi QR codes natively through the camera or a built-in scanner.'],
            ['question' => 'What if my Wi-Fi network is hidden?', 'answer' => 'You must check the "Hidden Network" option in our generator, otherwise phones won\'t know to search for your invisible SSID.'],
            ['question' => 'Which encryption should I choose?', 'answer' => 'Most modern home and business networks use WPA/WPA2/WPA3. Only choose WEP if you are sure you have an older, legacy router.'],
        ],
        'related_pages' => ['qr-code-for-restaurant-menu', 'qr-code-for-whatsapp', 'private-qr-code-generator', 'free-qr-code-generator', 'qr-code-with-logo'],
    ],

    'qr-code-with-logo' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-com-logotipo',
        'title' => 'QR Code with Logo Generator | Free Custom Branded QR Codes',
        'meta_description' => 'Create beautiful, custom QR codes with your company logo in the center. Free to use, no signup required, and generated locally for maximum privacy.',
        'h1' => 'QR Code with Logo',
        'intro' => 'Make your QR codes stand out by adding your own branding. Upload your company logo or a custom icon to be placed securely in the center of your QR code without affecting its scannability.',
        'qr_type' => 'url',
        'use_cases' => [
            'Branded product packaging and user manuals.',
            'Marketing banners and promotional posters.',
            'Professional business cards with an embedded company logo.',
        ],
        'steps' => [
            'Enter your destination URL or data.',
            'Click the logo upload button and select a square image from your device.',
            'Adjust the primary color of the QR code to match your brand.',
            'Generate and test the QR code before downloading.'
        ],
        'faqs' => [
            ['question' => 'Will adding a logo make the QR code unreadable?', 'answer' => 'No. We automatically use the highest level of error correction (Level H), which allows up to 30% of the QR code to be covered without losing data.'],
            ['question' => 'What is the best logo size?', 'answer' => 'Keep the logo small. We automatically scale it to cover no more than 25% of the code. Square images (1:1 ratio) look the best.'],
            ['question' => 'Can I use transparent PNG logos?', 'answer' => 'Yes, transparent PNGs are fully supported and will blend nicely with the background color of your QR code.'],
            ['question' => 'Do I have to pay to add a logo?', 'answer' => 'No, adding a logo is completely free, with no watermarks or hidden premium fees.'],
            ['question' => 'Are my uploaded logos stored on your server?', 'answer' => 'No. Your logo is processed locally in your web browser. We do not upload your images to our servers.'],
        ],
        'related_pages' => ['qr-code-for-business-card', 'qr-code-for-restaurant-menu', 'free-qr-code-generator', 'qr-code-for-whatsapp', 'static-qr-code-generator'],
    ],

    'qr-code-for-business-card' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-para-cartao-de-visita',
        'title' => 'vCard QR Code Generator | Digital Business Cards',
        'meta_description' => 'Generate a free vCard QR code. Let people scan and save your contact information directly to their phonebook instantly. No account required.',
        'h1' => 'QR Code for Business Card (vCard)',
        'intro' => 'Turn your physical business card into a digital experience. By generating a vCard QR code, you allow anyone who scans it to instantly save your name, phone number, email, and company details straight to their smartphone contacts.',
        'qr_type' => 'vcard',
        'use_cases' => [
            'Networking events, conferences, and trade shows.',
            'Printed on the back of traditional paper business cards.',
            'Added to digital email signatures or resume PDFs.',
        ],
        'steps' => [
            'Fill out your contact details (Name, Phone, Email, Company).',
            'Leave any optional fields blank if you don\'t want to share them.',
            'Customize the look with your brand colors.',
            'Download the QR code and print it on your networking materials.'
        ],
        'faqs' => [
            ['question' => 'What is a vCard QR Code?', 'answer' => 'A vCard QR code contains structured text (the vCard format) that smartphones recognize as a digital contact card.'],
            ['question' => 'Do users need a special app to save my contact?', 'answer' => 'No. Most modern iPhone and Android cameras will detect the vCard and prompt the user to "Add to Contacts" automatically.'],
            ['question' => 'Can I update my details later?', 'answer' => 'No. Because this is a static QR code, your contact details are baked directly into the image. If you change your phone number, you must generate a new QR code.'],
            ['question' => 'Why does my QR code look so dense and complex?', 'answer' => 'vCards contain a lot of text. The more data a QR code holds, the more "dots" it needs. Keep your details concise if you want a simpler-looking code.'],
            ['question' => 'Is it safe to put my phone number in a QR code?', 'answer' => 'Anyone who scans the code will see the information you provide. Only include details you are comfortable sharing publicly.'],
        ],
        'related_pages' => ['qr-code-for-whatsapp', 'qr-code-with-logo', 'free-qr-code-generator', 'static-qr-code-generator', 'private-qr-code-generator'],
    ],

    'qr-code-for-restaurant-menu' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-para-menu-de-restaurante',
        'title' => 'QR Code for Restaurant Menu | Free PDF Menu Generator',
        'meta_description' => 'Create a free QR code for your restaurant menu. Link directly to your PDF or website menu. Touchless, permanent, and no subscription required.',
        'h1' => 'QR Code for Restaurant Menu',
        'intro' => 'Provide a touchless dining experience by creating a QR code for your restaurant menu. Link guests directly to your online menu or a hosted PDF file instantly and for free.',
        'qr_type' => 'url',
        'use_cases' => [
            'Table tents and tabletop stickers in restaurants and bars.',
            'Takeout menus and delivery flyers.',
            'Window displays for pedestrians to view your menu outside hours.',
        ],
        'steps' => [
            'Host your PDF menu online (e.g., on Google Drive, Dropbox, or your website).',
            'Paste the public URL link into our generator.',
            'Add your restaurant logo to the center of the QR code.',
            'Print the QR code and place it on your tables.'
        ],
        'faqs' => [
            ['question' => 'Do you host my PDF menu?', 'answer' => 'No, we do not host files. You must upload your menu to a cloud drive (like Google Drive) or your own website and paste the link here.'],
            ['question' => 'Can I update my menu without printing a new QR code?', 'answer' => 'Yes, if you keep the same URL. For example, if you replace the PDF file on your web server but keep the file name identical, the old QR code will still work.'],
            ['question' => 'Do I have to pay a monthly fee for my menu QR code?', 'answer' => 'Absolutely not. Our generated QR codes are static and permanent. You will never be charged a subscription fee.'],
            ['question' => 'What size should I print the QR code for tables?', 'answer' => 'We recommend a minimum size of 1.5 x 1.5 inches (4 x 4 cm) for easy scanning under typical restaurant lighting.'],
            ['question' => 'Can I add my restaurant logo?', 'answer' => 'Yes! Use the logo upload feature to make the QR code match your restaurant\'s branding.'],
        ],
        'related_pages' => ['qr-code-for-wifi', 'qr-code-with-logo', 'free-qr-code-generator', 'qr-code-for-whatsapp', 'static-qr-code-generator'],
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
        'related_pages' => ['qr-code-for-whatsapp', 'qr-code-with-logo', 'qr-code-for-business-card', 'qr-code-for-restaurant-menu', 'free-qr-code-generator'],
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
        'related_pages' => ['qr-code-for-restaurant-menu', 'free-qr-code-generator', 'qr-code-with-logo', 'qr-code-for-wifi', 'static-qr-code-generator'],
    ],

    'qr-code-for-location' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-para-localizacao',
        'title' => 'QR Code for Location — Open Google Maps Instantly | QrGenerate',
        'meta_description' => 'Create a QR code that opens a specific location on Google Maps. Perfect for event invitations, business cards, and signage.',
        'h1' => 'QR Code for Location',
        'intro' => 'Help people find you. Create a QR code that opens a precise location on Google Maps or any map app. Use a Google Maps share link or geo-coordinates in the format <code>geo:LAT,LNG</code>.',
        'qr_type' => 'location',
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
        'related_pages' => ['qr-code-for-restaurant-menu', 'qr-code-for-business-card', 'qr-code-for-whatsapp', 'qr-code-for-wifi', 'qr-code-for-instagram'],
    ],

    'qr-code-for-email' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-para-email',
        'title' => 'QR Code for Email — Pre-Fill Address, Subject & Body | QrGenerate',
        'meta_description' => 'Generate a QR code that opens a pre-filled email. Set the recipient, subject line, and body text automatically.',
        'h1' => 'QR Code for Email',
        'intro' => 'Make it easy for people to email you. Create a QR code using the <code>mailto:</code> format that pre-fills the recipient address, subject line, and body text. One scan opens the email app ready to send.',
        'qr_type' => 'email',
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
        'related_pages' => ['qr-code-for-sms', 'qr-code-for-whatsapp', 'qr-code-for-business-card', 'private-qr-code-generator', 'qr-code-for-instagram'],
    ],

    'qr-code-for-sms' => [
        'locale' => 'en',
        'alternate_slug' => 'qr-code-para-sms',
        'title' => 'QR Code for SMS — Pre-Fill a Text Message | QrGenerate',
        'meta_description' => 'Create a QR code that opens a pre-filled SMS message. Set the phone number and message text automatically.',
        'h1' => 'QR Code for SMS',
        'intro' => 'Generate a QR code that opens the messaging app with a pre-filled phone number and text. Use the format <code>sms:+1234567890?body=Your+Message</code> or <code>SMSTO:+1234567890:Your Message</code>.',
        'qr_type' => 'sms',
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
        'related_pages' => ['qr-code-for-whatsapp', 'qr-code-for-email', 'free-qr-code-generator', 'qr-code-for-business-card', 'qr-code-for-instagram'],
    ],

];
