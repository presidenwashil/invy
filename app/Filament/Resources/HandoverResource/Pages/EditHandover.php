<?php

declare(strict_types=1);

namespace App\Filament\Resources\HandoverResource\Pages;

use App\Filament\Resources\HandoverResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

final class EditHandover extends EditRecord
{
    protected static string $resource = HandoverResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('exportPdf')
                ->label('Export PDF')
                ->icon('heroicon-o-document-text')
                ->url(fn () => route('handover.pdf', ['record' => $this->getRecord()->id]))
                ->openUrlInNewTab(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
