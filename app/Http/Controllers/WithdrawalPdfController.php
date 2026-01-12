<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Withdrawal;

final class WithdrawalPdfController extends Controller
{
    public function __invoke($record)
    {
        $withdrawal = Withdrawal::with(['details', 'details.item', 'staff'])->findOrFail($record);

        return view('pdf.withdrawal', compact('withdrawal'));
    }
}
