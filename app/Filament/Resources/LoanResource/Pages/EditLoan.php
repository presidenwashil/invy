<?php

declare(strict_types=1);

namespace App\Filament\Resources\LoanResource\Pages;

use App\Filament\Resources\LoanResource;
use Filament\Actions;

/**
 * @extends \App\Filament\Pages\BaseEditRecord<\App\Models\Loan>
 */
final class EditLoan extends \App\Filament\Pages\BaseEditRecord
{
    protected static string $resource = LoanResource::class;

    public function afterSave()
    {
        // loan memiliki banyak detail
        // apabila setiap detail loan status peminjamannya berubah menjadi returned,
        // maka update status inventory menjadi available

        if ($this->getRecord()->details->every(fn ($detail) => $detail->loan_status === 'returned')) {
            $this->getRecord()->details->each(fn ($detail) => $detail->inventory->update([
                'status' => 'available',
            ]));
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
