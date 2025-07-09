<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Handover;
use Barryvdh\DomPDF\Facade\Pdf;

final class HandoverPdfController extends Controller
{
    public function __invoke($record)
    {
        $handover = Handover::findOrFail($record);
        $pdf = Pdf::loadView('pdf.handover', compact('handover'));

        return $pdf->stream('handover_'.$handover->id.'.pdf');
    }
}
