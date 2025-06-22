<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderPdfController extends Controller
{
    public function generatePDF($orderId)
    {
        // Ambil data order berdasarkan ID
        $order = Order::with('details.item')->find($orderId);

        // Jika order tidak ditemukan, return error
        if (! $order) {
            return redirect()->back()->with('error', 'Order not found!');
        }

        // Siapkan data untuk dikirim ke view
        $data = ['order' => $order];

        // Konversi data menjadi PDF
        $pdf = Pdf::loadView('pdf.order', $data);

        // Download PDF
        return $pdf->download('order_'.$order->order_number.'.pdf');
    }
}
