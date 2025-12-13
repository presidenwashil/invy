<?php

declare(strict_types=1);

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Resources\LoanResource;

/**
 * @extends \App\Filament\Pages\BaseCreateRecord<\App\Models\Loan>
 */
final class CreateLoan extends \App\Filament\Pages\BaseCreateRecord
{
    protected static string $resource = LoanResource::class;

    public function afterCreate()
    {
        foreach ($this->record->details as $detail) {
            $detail->inventory->update([
                'status' => 'borrowed',
            ]);
        }
    }
}
