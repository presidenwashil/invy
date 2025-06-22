<?php

namespace App\Http\Controllers;

use App\Models\Handover;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class HandoverPdfController extends Controller
{
    public function __invoke($record){
        $handover = Handover::findOrFail($record);
        $pdf = Pdf::loadView('pdf.handover', compact('handover'));

        return $pdf->download('handover_' . $handover->id . '.pdf');
    }
}
