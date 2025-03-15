<?php

namespace App\Filament\Resources\PurchaseOrderDetailResource\Pages;

use App\Filament\Resources\PurchaseOrderDetailResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPurchaseOrderDetail extends EditRecord
{
    protected static string $resource = PurchaseOrderDetailResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
