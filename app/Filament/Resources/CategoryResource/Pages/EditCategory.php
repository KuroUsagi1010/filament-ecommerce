<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * Ensure we record the user who edited the product
     */
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['modified_by'] = auth()->id(); // set last edit author

        return $data;
    }
}
