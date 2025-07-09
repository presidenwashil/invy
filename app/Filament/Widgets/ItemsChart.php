<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Models\Category;
use Filament\Widgets\ChartWidget;

final class ItemsChart extends ChartWidget
{
    protected static ?string $heading = 'Total Barang per Kategori';

    protected static ?int $sort = 1;

    protected function getData(): array
    {

        $data = Category::with(['items' => function ($query) {
            $query->select('id', 'category_id', 'stock');
        }])->get();

        return [
            'datasets' => [
                [
                    'label' => 'Total Stok',
                    'data' => $data->map(function ($category) {
                        return $category->items->sum('stock');
                    })->toArray(),
                ],
            ],
            'labels' => $data->pluck('name')->toArray(),
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
