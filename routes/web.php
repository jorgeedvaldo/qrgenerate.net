<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\QrPageController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\RobotsController;
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

// Portuguese QR pages
Route::get('/pt/{slug}', [QrPageController::class, 'showPt'])
    ->name('qr-page.pt')
    ->where('slug', '[a-z0-9\-]+');

// English QR pages (catch-all — must be LAST)
Route::get('/{slug}', [QrPageController::class, 'show'])
    ->name('qr-page.en')
    ->where('slug', '^(?!pt$|api|storage|sitemap|robots|articles).[a-z0-9\-]+$');
