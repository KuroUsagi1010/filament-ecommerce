<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Filament\Resources\ProductResource\RelationManagers\VariantsRelationManager;
use App\Models\Product;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Product Information')
                    ->description('Enter the product name, description, and price to be displayed.')
                    ->schema([
                        // Section to hold name and Brand
                        Section::make()
                            ->columns([
                                'sm' => 2,
                            ])
                            ->schema([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('brand')
                                    ->maxLength(255)
                            ]),
                        Select::make('categories')
                            ->relationship('categories', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->required()
                            ->createOptionForm([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                            ])->createOptionUsing(function (array $data): int {
                                return auth()->user()->categories()->create($data)->getKey();
                            })->editOptionForm([
                                TextInput::make('name')
                                    ->required()
                                    ->maxLength(255),
                            ])
                            ->helperText("Click the plus button on the right side to add new categories."),
                        RichEditor::make('description')
                            ->toolbarButtons([
                                'attachFiles',
                                'blockquote',
                                'bold',
                                'bulletList',
                                'codeBlock',
                                'heading',
                                'italic',
                                'link',
                                'orderedList',
                                'redo',
                                'strike',
                                'table',
                                'undo',
                            ])
                            ->fileAttachmentsDirectory('products')
                            ->fileAttachmentsVisibility('private'),
                        FileUpload::make('images')
                            ->multiple()
                            ->required()
                            ->image()
                            ->directory('products')
                            ->acceptedFileTypes(['image/jpeg', 'image/png'])
                            ->maxFiles(10)
                            ->maxSize(10000),
                    ]),

                // Variants relations repeater
                Section::make('Product Variants')
                    ->description('Define multiple variations for this product.')
                    ->schema([
                        Repeater::make('variants')
                            ->relationship()
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
                                FileUpload::make('image')
                                    ->image()
                                    ->directory('products/variants')
                                    ->acceptedFileTypes(['image/jpeg', 'image/png'])
                                    ->maxFiles(10)
                                    ->maxSize(10000)
                                    ->columnSpan(3),
                            ])
                            ->addActionLabel('Add Variant')
                            ->cloneable()
                            ->columns(2)
                            ->mutateRelationshipDataBeforeCreateUsing(function (array $data): array {
                                $data['user_id'] = auth()->id();

                                return $data;
                            })
                    ])
                    ->hiddenOn('edit'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            VariantsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
