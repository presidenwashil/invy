<?php

declare(strict_types=1);

use App\Models\Category;
use App\Models\Handover;
use App\Models\HandoverDetail;
use App\Models\Inventory;
use App\Models\Item;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

it('Category items() returns HasMany relationship', function () {
    $category = new Category();
    expect($category->items())->toBeInstanceOf(HasMany::class);
});

it('Handover staff() returns BelongsTo relationship', function () {
    $handover = new Handover();
    expect($handover->staff())->toBeInstanceOf(BelongsTo::class);
});

it('Handover details() returns HasMany relationship', function () {
    $handover = new Handover();
    expect($handover->details())->toBeInstanceOf(HasMany::class);
});

it('HandoverDetail inventory() returns BelongsTo relationship', function () {
    $detail = new HandoverDetail();
    expect($detail->inventory())->toBeInstanceOf(BelongsTo::class);
});

it('Inventory item() returns BelongsTo relationship', function () {
    $inventory = new Inventory();
    expect($inventory->item())->toBeInstanceOf(BelongsTo::class);
});

it('Item warehouses() returns BelongsToMany relationship', function () {
    $item = new Item();
    expect($item->warehouses())->toBeInstanceOf(BelongsToMany::class);
});
