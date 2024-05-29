<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class VariantsRelationManager extends RelationManager
{
    protected static string $relationship = 'variants';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->placeholder("ex: Black Color, Linen Material, Size 8")
                    ->required()
                    ->maxLength(255),
                TextInput::make('price')
                    ->prefix('₱')
                    ->required()
                    ->numeric(),
                TextInput::make('available_stock')
                    ->placeholder("10")
                    ->required()
                    ->numeric(),
                TextInput::make('sku')
                    ->label("SKU")
                    ->placeholder("NK-SZ10-BLK-100")
                    ->helperText("You may add a custom SKU or leave it blank and we will generate an SKU for you")
                    ->columnSpan(2),
                FileUpload::make('image')
                    ->image()
                    ->directory('products/variants')
                    ->acceptedFileTypes(['image/jpeg', 'image/png'])
                    ->maxFiles(10)
                    ->maxSize(10000)
                    ->columnSpan(3),
            ]);
    }


    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('image')
                    ->circular()
                    ->visibility('private'),
                TextColumn::make('name')->searchable(),
                TextColumn::make('price')->money(),
                TextColumn::make('available_stock')
                    ->sortable(),
                TextColumn::make('sku')
                    ->searchable()
                    ->label("SKU")
                    ->tooltip("Stock Keeping Unit"),
                TextColumn::make('user.name')
                    ->label("Added by"),
                TextColumn::make('editor.name')
                    ->label("Modified by"),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->mutateFormDataUsing(function (array $data): array {
                    $data['user_id'] = auth()->id();
                    return $data;
                }),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->mutateFormDataUsing(function (array $data): array {
                    $data['modified_by'] = auth()->id();
                    return $data;
                }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
