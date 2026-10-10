<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\QrPageController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\InvitationController;
use App\Http\Controllers\InvitationGuestController;
use App\Http\Controllers\PublicInvitationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\GoogleAuthController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Order matters: specific routes first, catch-all slugs last.
|--------------------------------------------------------------------------
*/

// SEO files
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');
Route::get('/robots.txt', RobotsController::class)->name('robots');

// Home pages
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/pt', [HomeController::class, 'indexPt'])->name('home.pt');

// Institutional pages — English
use App\Http\Controllers\PageController;
Route::get('/privacy-policy', [PageController::class, 'privacy'])->name('privacy');
Route::get('/terms-of-use', [PageController::class, 'terms'])->name('terms');
Route::get('/about', [PageController::class, 'about'])->name('about');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');

// Institutional pages — Portuguese
Route::get('/pt/politica-de-privacidade', [PageController::class, 'privacyPt'])->name('privacy.pt');
Route::get('/pt/termos-de-uso', [PageController::class, 'termsPt'])->name('terms.pt');
Route::get('/pt/sobre', [PageController::class, 'aboutPt'])->name('about.pt');
Route::get('/pt/contacto', [PageController::class, 'contactPt'])->name('contact.pt');

// Articles — English
Route::get('/articles', [ArticleController::class, 'index'])
    ->name('articles.index')
    ->defaults('locale', 'en');
Route::get('/articles/{slug}', [ArticleController::class, 'show'])
    ->name('articles.show')
    ->defaults('locale', 'en')
    ->where('slug', '[a-z0-9\-]+');

// Articles — Portuguese
Route::get('/pt/artigos', [ArticleController::class, 'index'])
    ->name('articles.index.pt')
    ->defaults('locale', 'pt');
Route::get('/pt/artigos/{slug}', [ArticleController::class, 'show'])
    ->name('articles.show.pt')
    ->defaults('locale', 'pt')
    ->where('slug', '[a-z0-9\-]+');

// ─── Digital Menu / Cardápio Digital ────────────────────────────────────────
// SEO landing pages
Route::get('/digital-menu-generator', [MenuController::class, 'landingEn'])
    ->name('menu.landing.en');
Route::get('/pt/gerador-de-cardapio-digital', [MenuController::class, 'landingPt'])
    ->name('menu.landing.pt');

// Create form — bilingual URLs
Route::get('/menu/create',    [MenuController::class, 'createEn'])->name('menu.create.en');
Route::get('/cardapio/criar', [MenuController::class, 'createPt'])->name('menu.create.pt');

// Store (single endpoint, locale-independent)
Route::post('/menu', [MenuController::class, 'store'])->name('menu.store');

// Success page
Route::get('/menu/{slug}/sucesso', [MenuController::class, 'success'])->name('menu.success')
    ->where('slug', '[a-z0-9\-]+');

// Edit form — bilingual URLs (must stay before {slug} catch-all)
Route::get('/menu/{slug}/editar', [MenuController::class, 'editPt'])->name('menu.edit.pt')
    ->where('slug', '[a-z0-9\-]+');
Route::get('/menu/{slug}/edit', [MenuController::class, 'editEn'])->name('menu.edit.en')
    ->where('slug', '[a-z0-9\-]+');

// Update
Route::put('/menu/{slug}', [MenuController::class, 'update'])->name('menu.update')
    ->where('slug', '[a-z0-9\-]+');

// Link recovery — bilingual (must be before {slug} catch-all)
Route::get('/menu/recuperar', [MenuController::class, 'recoverForm'])->name('menu.recover.pt');
Route::post('/menu/recuperar', [MenuController::class, 'recoverSend'])->name('menu.recover.send.pt');
Route::get('/menu/recover', [MenuController::class, 'recoverForm'])->name('menu.recover.en');
Route::post('/menu/recover', [MenuController::class, 'recoverSend'])->name('menu.recover.send.en');

// Public menu page
Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('menu.show')
    ->where('slug', '[a-z0-9\-]+');
// ────────────────────────────────────────────────────────────────────────────

// ─── Accounts: email + Google sign-in ───────────────────────────────────────
Route::middleware('guest')->group(function () {
    // Sign in
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])
        ->name('login')->defaults('locale', 'en');
    Route::post('/login', [AuthenticatedSessionController::class, 'store'])
        ->name('login.store')->defaults('locale', 'en')->middleware('throttle:10,1');
    Route::get('/pt/entrar', [AuthenticatedSessionController::class, 'create'])
        ->name('login.pt')->defaults('locale', 'pt');
    Route::post('/pt/entrar', [AuthenticatedSessionController::class, 'store'])
        ->name('login.store.pt')->defaults('locale', 'pt')->middleware('throttle:10,1');

    // Register
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register')->defaults('locale', 'en');
    Route::post('/register', [RegisteredUserController::class, 'store'])
        ->name('register.store')->defaults('locale', 'en')->middleware('throttle:10,1');
    Route::get('/pt/criar-conta', [RegisteredUserController::class, 'create'])
        ->name('register.pt')->defaults('locale', 'pt');
    Route::post('/pt/criar-conta', [RegisteredUserController::class, 'store'])
        ->name('register.store.pt')->defaults('locale', 'pt')->middleware('throttle:10,1');

    // Forgot password
    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request')->defaults('locale', 'en');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->name('password.email')->defaults('locale', 'en')->middleware('throttle:6,1');
    Route::get('/pt/recuperar-senha', [PasswordResetLinkController::class, 'create'])
        ->name('password.request.pt')->defaults('locale', 'pt');
    Route::post('/pt/recuperar-senha', [PasswordResetLinkController::class, 'store'])
        ->name('password.email.pt')->defaults('locale', 'pt')->middleware('throttle:6,1');

    // Choose a new password
    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset')->defaults('locale', 'en');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->name('password.store')->defaults('locale', 'en');
    Route::get('/pt/redefinir-senha/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset.pt')->defaults('locale', 'pt');
    Route::post('/pt/redefinir-senha', [NewPasswordController::class, 'store'])
        ->name('password.store.pt')->defaults('locale', 'pt');

    // Google
    Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google');
    Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');
});

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout')->middleware('auth');

// ─── Wedding & Engagement Invitations / Convites ────────────────────────────
// SEO landing pages
Route::get('/wedding-invitation-generator', [InvitationController::class, 'landingEn'])
    ->name('invitation.landing.en');
Route::get('/pt/convite-de-casamento-online', [InvitationController::class, 'landingPt'])
    ->name('invitation.landing.pt');

// Owner dashboard
Route::middleware('auth')->group(function () {
    Route::get('/invitations', [InvitationController::class, 'index'])->name('invitations.index');
    Route::get('/invitations/create', [InvitationController::class, 'create'])->name('invitations.create');
    Route::post('/invitations', [InvitationController::class, 'store'])->name('invitations.store');

    Route::get('/invitations/{slug}/edit', [InvitationController::class, 'edit'])
        ->name('invitations.edit')->where('slug', '[a-z0-9\-]+');
    Route::put('/invitations/{slug}', [InvitationController::class, 'update'])
        ->name('invitations.update')->where('slug', '[a-z0-9\-]+');
    Route::delete('/invitations/{slug}', [InvitationController::class, 'destroy'])
        ->name('invitations.destroy')->where('slug', '[a-z0-9\-]+');

    Route::get('/invitations/{slug}/share', [InvitationController::class, 'share'])
        ->name('invitations.share')->where('slug', '[a-z0-9\-]+');
    Route::get('/invitations/{slug}/rsvps', [InvitationController::class, 'rsvps'])
        ->name('invitations.rsvps')->where('slug', '[a-z0-9\-]+');
    Route::get('/invitations/{slug}/rsvps.csv', [InvitationController::class, 'rsvpsCsv'])
        ->name('invitations.rsvps.csv')->where('slug', '[a-z0-9\-]+');

    Route::get('/invitations/{slug}/guests', [InvitationGuestController::class, 'index'])
        ->name('invitations.guests')->where('slug', '[a-z0-9\-]+');
    Route::post('/invitations/{slug}/guests', [InvitationGuestController::class, 'store'])
        ->name('invitations.guests.store')->where('slug', '[a-z0-9\-]+');
    Route::post('/invitations/{slug}/guests/bulk', [InvitationGuestController::class, 'storeBulk'])
        ->name('invitations.guests.bulk')->where('slug', '[a-z0-9\-]+');
    Route::delete('/invitations/{slug}/guests/{guest}', [InvitationGuestController::class, 'destroy'])
        ->name('invitations.guests.destroy')->where('slug', '[a-z0-9\-]+');
});

// Public invitation page
Route::get('/convite/{slug}', [PublicInvitationController::class, 'show'])
    ->name('invitation.show')->where('slug', '[a-z0-9\-]+');
Route::post('/convite/{slug}/confirmar', [PublicInvitationController::class, 'rsvp'])
    ->name('invitation.rsvp')->where('slug', '[a-z0-9\-]+')->middleware('throttle:20,1');
Route::post('/convite/{slug}/recado', [PublicInvitationController::class, 'message'])
    ->name('invitation.message')->where('slug', '[a-z0-9\-]+')->middleware('throttle:20,1');
Route::post('/convite/{slug}/presente/{gift}', [PublicInvitationController::class, 'reserveGift'])
    ->name('invitation.gift.reserve')->where('slug', '[a-z0-9\-]+')->middleware('throttle:20,1');
// ────────────────────────────────────────────────────────────────────────────

// Portuguese QR pages (must come after explicit PT routes above)
Route::get('/pt/{slug}', [QrPageController::class, 'showPt'])
    ->name('qr-page.pt')
    ->where('slug', '[a-z0-9\-]+');

// English QR pages (catch-all — must be LAST)
Route::get('/{slug}', [QrPageController::class, 'show'])
    ->name('qr-page.en')
    ->where('slug', '^(?!pt$|api|storage|sitemap|robots|articles|menu|cardapio|digital-menu-generator|convite|invitations|login|register|logout|forgot-password|reset-password|auth|up$|wedding-invitation-generator).[a-z0-9\-]+$');
