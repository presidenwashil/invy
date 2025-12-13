<?php

declare(strict_types=1);

namespace App\Filament\Resources\HandoverResource\Pages;

use App\Filament\Resources\HandoverResource;
use Filament\Actions;

/**
 * @extends \App\Filament\Pages\BaseEditRecord<\App\Models\Handover>
 */
final class EditHandover extends \App\Filament\Pages\BaseEditRecord
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
