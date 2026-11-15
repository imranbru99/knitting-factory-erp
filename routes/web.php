<?php

use App\Http\Controllers\SiteController;
use App\Modules\Support\SpreadsheetExport;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'home']);
Route::get('/fabrics', [SiteController::class, 'fabrics'])->name('fabrics');
Route::get('/quote', [SiteController::class, 'quoteForm']);
Route::post('/quote', [SiteController::class, 'quote'])->middleware('throttle:10,1');
Route::get('/career', [SiteController::class, 'career']);
Route::post('/career', [SiteController::class, 'apply'])->middleware('throttle:10,1');
Route::get('/sitemap.xml', [SiteController::class, 'sitemap']);
Route::get('/health', [SiteController::class, 'health']);
Route::post('/cookie', function () {
    return back()->cookie('gk_cookie', '1', 60 * 24 * 180);
});
Route::view('/floor', 'floor.index');
Route::get('/robots.txt', function () {
    return response("User-agent: *\nAllow: /\nSitemap: ".url('/sitemap.xml')."\n", 200, ['Content-Type' => 'text/plain']);
});

foreach (['about', 'capacity', 'process', 'quality', 'sustainability', 'clients', 'gallery', 'news', 'downloads', 'contact', 'faq'] as $page) {
    Route::get('/'.$page, fn () => app(SiteController::class)->page(request(), $page));
}

Route::middleware('auth')->get('/reports/{report}.xlsx', function (string $report, SpreadsheetExport $export) {
    $rows = app(\App\Modules\Support\ReportBook::class)->rows($report);

    return $export->downloadRows($report, $rows['headers'], $rows['rows']);
});
