<?php

use App\Http\Controllers\EnquiryController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/', [SiteController::class, 'index'])->name('index');
Route::post('/enquiries/submit/', [EnquiryController::class, 'submit'])->name('enquiries.submit');
Route::get('/properties/', [SiteController::class, 'properties'])->name('properties.list');
Route::get('/properties/{slug}/', [SiteController::class, 'propertyDetail'])->name('properties.detail');
Route::get('/about/', [SiteController::class, 'about'])->name('about');
Route::get('/contact/', [SiteController::class, 'contact'])->name('contact');
Route::get('/support/', [SiteController::class, 'support'])->name('support');
Route::get('/privacy-policy/', [SiteController::class, 'privacyPolicy'])->name('privacy_policy');
Route::get('/terms/', [SiteController::class, 'terms'])->name('terms');
Route::get('/sitemap/', [SiteController::class, 'sitemap'])->name('sitemap');
Route::get('/careers/', [SiteController::class, 'careers'])->name('careers');
Route::get('/blog/', [SiteController::class, 'blogList'])->name('blog.list');
Route::get('/blog/{slug}/', [SiteController::class, 'blogDetail'])->name('blog.detail');
