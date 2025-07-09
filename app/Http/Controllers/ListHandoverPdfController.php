<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Handover;
use Illuminate\Http\Request;

final class ListHandoverPdfController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = Handover::query();

        $filters = $request->input('tableFilters', []);

        $year = $filters['year']['year'] ?? null;

        if ($year) {
            $query->whereYear('handover_date', (int) $year);
        }

        if (! empty($filters['month']['value'])) {
            $month = (int) $filters['month']['value'];
            $query->whereMonth('handover_date', $month);
        }

        $handovers = $query->get();

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.list-handover', compact('handovers'));

        return $pdf->stream('list-handover.pdf');
    }
}
