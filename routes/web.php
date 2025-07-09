<?php

declare(strict_types=1);

use App\Http\Controllers\HandoverPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/handover/{record}/pdf', HandoverPdfController::class)->name('handover.pdf');
Route::get('/handover/pdf', \App\Http\Controllers\ListHandoverPdfController::class)->name('list-handover');
