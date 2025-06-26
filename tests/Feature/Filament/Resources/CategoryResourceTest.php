<?php

use App\Filament\Resources\CategoryResource;
use App\Models\Category;
use Filament\Actions\DeleteAction;

use function Pest\Livewire\livewire;

it('can render category resource', function () {
    $this->get(CategoryResource::getUrl('index'))->assertSuccessful();
});

it('can list categories', function () {
    $categories = Category::factory()->count(10)->create();

    livewire(CategoryResource\Pages\ListCategories::class)
        ->assertCanSeeTableRecords($categories);
});

it('can render create category page', function () {
    $this->get(CategoryResource::getUrl('create'))->assertSuccessful();
});

it('can create category', function () {
    $newData = Category::factory()->make();

    livewire(CategoryResource\Pages\CreateCategory::class)
        ->fillForm([
            'code' => $newData->code,
            'name' => $newData->name,
        ])
        ->call('create')
        ->assertHasNoFormErrors();

    $this->assertDatabaseHas(Category::class, [
        'code' => $newData->code,
        'name' => $newData->name,
    ]);
});

it('can validate input category', function () {
    livewire(CategoryResource\Pages\CreateCategory::class)
        ->fillForm([
            'code' => null,
        ])
        ->call('create')
        ->assertHasFormErrors(['code' => 'required']);
});

it('can render edit category page', function () {
    $this->get(CategoryResource::getUrl('edit', [
        'record' => Category::factory()->create(),
    ]))->assertSuccessful();
});

it('can retrieve data for editing category', function () {
    $category = Category::factory()->create();

    livewire(CategoryResource\Pages\EditCategory::class, [
        'record' => $category->getRouteKey(),
    ])
        ->assertFormSet([
            'code' => $category->code,
            'name' => $category->name,
        ]);
});

it('can save edited category', function () {
    $category = Category::factory()->create();
    $newData = Category::factory()->make();

    livewire(CategoryResource\Pages\EditCategory::class, [
        'record' => $category->getRouteKey(),
    ])
        ->fillForm([
            'code' => $newData->code,
            'name' => $newData->name,
        ])
        ->call('save')
        ->assertHasNoFormErrors();

    expect($category->refresh())
        ->code->toBe($newData->code)
        ->name->toBe($newData->name);
});

it('can validate input for editing category', function () {
    $category = Category::factory()->create();

    livewire(CategoryResource\Pages\EditCategory::class, [
        'record' => $category->getRouteKey(),
    ])
        ->fillForm([
            'code' => null,
        ])
        ->call('save')
        ->assertHasFormErrors(['code' => 'required']);
});

it('can soft delete category', function () {
    $category = Category::factory()->create();

    livewire(CategoryResource\Pages\EditCategory::class, [
        'record' => $category->getRouteKey(),
    ])
        ->callAction(DeleteAction::class);

    $this->assertSoftDeleted($category);
});
