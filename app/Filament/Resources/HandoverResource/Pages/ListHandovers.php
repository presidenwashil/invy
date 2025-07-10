<?php

declare(strict_types=1);

namespace App\Filament\Resources\HandoverResource\Pages;

use App\Filament\Resources\HandoverResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

final class ListHandovers extends ListRecords
{
    protected static string $resource = HandoverResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('export-pdf')
                ->label(__('Export PDF'))
                ->icon('heroicon-o-document')
                ->url(function () {
                    $currentUrl = request()->fullUrl();
                    $urlParts = parse_url($currentUrl);
                    $queryString = $urlParts['query'] ?? '';

                    return route('list-handover').($queryString ? '?'.$queryString : '');
                })
                ->openUrlInNewTab()
                ->color('danger'),
            Actions\CreateAction::make(),
        ];
    }
}
