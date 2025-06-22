<?php

use App\Http\Controllers\HandoverPdfController;
use App\Http\Controllers\OrderPdfController;
use Illuminate\Support\Facades\Route;

Route::get('/orders/{orderId}/pdf', [OrderPdfController::class, 'generatePDF'])->name('orders.pdf');
Route::get('/handover/{record}/pdf', HandoverPdfController::class)->name('handover.pdf');
