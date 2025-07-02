<?php

declare(strict_types=1);

use App\Filament\Resources\CategoryResource\Pages\ListCategories;
use App\Models\Category;

use function Pest\Livewire\livewire;

it('can render page', function () {
    livewire(ListCategories::class)->assertSuccessful();
});

it('cannot display trashed categories by default', function () {
    $category = Category::factory()->count(4)->create();
    $trashedCategory = Category::factory()->trashed()->count(6)->create();

    livewire(ListCategories::class)
        ->assertCanSeeTableRecords($category)
        ->assertCanNotSeeTableRecords($trashedCategory)
        ->assertCountTableRecords(4);
});
