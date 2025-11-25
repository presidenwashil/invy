<?php

declare(strict_types=1);

use App\Http\Controllers\HandoverPdfController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/handover/{record}/pdf', HandoverPdfController::class)->name('handover.pdf');
Route::get('/handover/pdf', App\Http\Controllers\ListHandoverPdfController::class)->name('list-handover');

Route::get('/test-vercel-storage', function () {
    dd(Storage::disk('r2')->put('test.txt', 'hello'));
});