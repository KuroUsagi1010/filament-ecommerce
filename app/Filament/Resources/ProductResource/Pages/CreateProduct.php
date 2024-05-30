<?php

namespace App\Filament\Resources\ProductResource\Pages;

use App\Filament\Resources\ProductResource;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id(); // set creator of the product
        $data['modified_by'] = auth()->id(); // set creator of the product
        $data['slug'] = Str::slug($data['name']) . "-" . Str::uuid(); // set a url friendly string

        return $data;
    }
}
