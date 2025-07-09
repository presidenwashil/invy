<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\ItemHistory;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Number;

final class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 0;

    protected function getStats(): array
    {
        $newItem = (int) ItemHistory::where('in', '>', 0)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('in');

        $itemOut = (int) ItemHistory::where('out', '>', 0)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->sum('out');

        $formatNumber = function (int $number): string {
            if ($number < 1000) {
                return (string) Number::format($number, 0);
            }

            if ($number < 1000000) {
                return Number::format($number / 1000, 2).'k';
            }

            return Number::format($number / 1000000, 2).'m';
        };

        return [
            Stat::make('Total Barang Masuk', $formatNumber($newItem))
                ->label('Barang Masuk')
                ->value($newItem)
                ->description('Barang masuk pada bulan ini')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->chart([7, 2, 10, 3, 15, 4, 17])
                ->color('success'),

            Stat::make('Total Barang Keluar', $formatNumber($itemOut))
                ->label('Barang Keluar')
                ->value($itemOut)
                ->description('Barang keluar pada bulan ini')
                ->descriptionIcon('heroicon-m-arrow-trending-down')
                ->chart([3, 5, 2, 8, 4, 6, 9])
                ->color('danger'),
        ];
    }
}
