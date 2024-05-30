<?php

use App\Filament\Resources\ProductResource;
use App\Filament\Resources\ProductResource\Pages\CreateProduct;
use App\Filament\Resources\ProductResource\Pages\ListProducts;
use App\Filament\Resources\UserResource\Pages\CreateUser;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;
use Livewire\Livewire;
use Illuminate\Support\Str;

use function Pest\Livewire\livewire;

it('can render page', function () {
    $this->get(ProductResource::getUrl('index'))->assertSuccessful();
});

it('can list products', function () {
    $products = Product::factory()->count(10)->create();

    livewire(ListProducts::class)
        ->assertCanSeeTableRecords($products);
});

it('can render create page', function () {
    $this->get(ProductResource::getUrl('create'))->assertSuccessful();
});


it('can create a product', function () {

    $user = auth()->user();
    $newData = Product::factory()->make(['user_id' => $user->id, 'modified_by' => $user->id]);

    // Create categories
    $categories = Category::factory()->count(2)->create(['user_id' => $user->id]);
    $categoryIds = $categories->pluck('id')->toArray();

    // // // Create product variants
    $variants = ProductVariant::factory()->count(2)->make(['user_id' => $user->id]);

    // // Structure the variants data for the repeater field
    $variantsData = $variants->map(function ($variant) use ($user) {
        return [
            'user_id' => $user->id,
            'name' => $variant->name,
            'available_stock' => $variant->available_stock,
            'price' => $variant->price,
            'sku' => $variant->sku,
            'image' => $variant->image
        ];
    })->toArray();

    info("VARIANTS", $variantsData);

    livewire(CreateProduct::class)
        ->set('data.variants', null)
        ->fillForm([
            'user_id' => $newData->user_id,
            'modified_by' => $newData->modified_by,
            'name' => $newData->name,
            'brand' => $newData->brand,
            'slug' => $newData->slug,
            'images' => $newData->images,
            'categories' => $categoryIds,
            'variants' => $variantsData,
        ])
        ->call('create')
        ->assertFormSet([
            'slug' => $newData->slug,
            'user_id' => $user->id,
            'modified_by' => $user->id
        ])
        ->assertHasNoFormErrors();


    $this->assertDatabaseHas(Product::class, [
        'user_id' => $user->id,
        'name' => $newData->name,
        'brand' => $newData->brand,
    ]);

    // retrieve the latest product record
    $record = Product::latest()->first();
    // check that variants are created for the latest product in the  test suite
    $this->assertDatabaseHas(ProductVariant::class, [
        'product_id' => $record->id,
    ]);
});
