<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CardHolderResource\Pages;
use App\Models\CardHolder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CardHolderResource extends Resource
{
    protected static ?string $model = CardHolder::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('card_id')
                    ->numeric(),
                Forms\Components\TextInput::make('nomor_identitas')
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_pemegang')
                    ->maxLength(255),
                Forms\Components\TextInput::make('jabatan')
                    ->maxLength(255),
                Forms\Components\TextInput::make('instansi')
                    ->maxLength(255),
                Forms\Components\TextInput::make('masa_berlaku')
                    ->maxLength(255),
                Forms\Components\TextInput::make('uuid')
                    ->maxLength(255),
                Forms\Components\TextInput::make('uuid_val')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('card_id')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor_identitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_pemegang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('instansi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('masa_berlaku')
                    ->searchable(),
                Tables\Columns\TextColumn::make('uuid')
                    ->searchable(),
                Tables\Columns\TextColumn::make('uuid_val')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCardHolders::route('/'),
        ];
    }
}
