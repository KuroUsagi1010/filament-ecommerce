<?php

namespace App\Filament\Resources;

use App\Enums\AccountRole;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('email')
                    ->email()
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->endsWith(["@" . config('app.filament.panel_domain')], fn (Get $get): bool => $get('role') == AccountRole::Admin->value)
                    ->helperText("If you are adding an admin. please make sure that the email domain is with @" . config('app.filament.panel_domain'))
                    ->validationMessages([
                        'ends_with' => 'The :attribute must use the domain @' . config('app.filament.panel_domain') . " if the account is an admin.",
                    ])
                    ->maxLength(255),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->dehydrated(fn ($state) => filled($state))
                    ->password()
                    ->revealable(fn (string $context): bool => $context === 'create')
                    ->required(fn (string $context): bool => $context === 'create')
                    ->maxLength(255),
                Select::make('role')
                    ->required()
                    ->default(AccountRole::User->value)
                    ->options(AccountRole::all()),
                Toggle::make('is_active')
                    ->required()
                    ->default(true)
                    ->inline(false)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->striped()
            ->columns([
                TextColumn::make('name')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('email')
                    ->searchable(),
                TextColumn::make('role')
                    ->sortable(),
                TextColumn::make('is_active')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? 'Active' : 'Inactive')
                    ->color(fn ($state) => $state ? 'success' : 'danger'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('role')
                    ->options(AccountRole::all()),
                SelectFilter::make('is_active')
                    ->label('Status')
                    ->options([
                        true => 'active',
                        false => 'inactive'
                    ])
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->checkIfRecordIsSelectableUsing(
                fn (Model $record): bool => $record->role !== AccountRole::Admin->value // lets prevent accidental delete when select all is present
            );
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
