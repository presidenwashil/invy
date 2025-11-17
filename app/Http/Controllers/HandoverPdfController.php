<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Handover;

final class HandoverPdfController extends Controller
{
    public function __invoke($record)
    {
        $handover = Handover::with(['details', 'details.inventory', 'details.inventory.item'])->findOrFail($record);

        return view('pdf.handover', compact('handover'));
    }
}
