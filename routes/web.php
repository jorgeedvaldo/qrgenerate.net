<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\QrPageController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RobotsController;
use App\Http\Controllers\MenuController;
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

// Public menu page
Route::get('/menu/{slug}', [MenuController::class, 'show'])->name('menu.show')
    ->where('slug', '[a-z0-9\-]+');
// ────────────────────────────────────────────────────────────────────────────

// Portuguese QR pages (must come after explicit PT routes above)
Route::get('/pt/{slug}', [QrPageController::class, 'showPt'])
    ->name('qr-page.pt')
    ->where('slug', '[a-z0-9\-]+');

// English QR pages (catch-all — must be LAST)
Route::get('/{slug}', [QrPageController::class, 'show'])
    ->name('qr-page.en')
    ->where('slug', '^(?!pt$|api|storage|sitemap|robots|articles|menu|cardapio|digital-menu-generator).[a-z0-9\-]+$');
