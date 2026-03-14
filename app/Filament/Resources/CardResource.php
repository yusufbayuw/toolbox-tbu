<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CardResource\Pages;
use App\Filament\Resources\CardResource\RelationManagers\HolderRelationManager;
use App\Models\Card;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CardResource extends Resource
{
    protected static ?string $model = Card::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';

    public static function getNavigationLabel(): string
    {
        return 'Card';
    }

    public static function getPluralModelLabel(): string
    {
        return 'Card';
    }

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole(['super_admin'])) {
            return parent::getEloquentQuery();
        }

        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->id()),
                Forms\Components\TextInput::make('nama_kartu')
                    ->label('Nama Kartu')
                    ->hint('misal: Kartu Identitas Pegawai')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('instansi')
                    ->label('Instansi Penerbit')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('masa_berlaku_label')
                    ->label('Label Masa Berlaku')
                    ->hint('misal: Berlaku hingga')
                    ->default('Berlaku hingga')
                    ->maxLength(255),
                Forms\Components\Textarea::make('deskripsi')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('nama_penandatangan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jabatan_penandatangan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\FileUpload::make('file_tandatangan')
                    ->disk(config('base_urls.default_disk'))
                    ->directory(fn () => 'card/'.date('Y').'/'.date('m'))
                    ->hint('saran: PNG transparan')
                    ->image(),
                Forms\Components\FileUpload::make('background_front')
                    ->disk(config('base_urls.default_disk'))
                    ->directory(fn () => 'card/'.date('Y').'/'.date('m'))
                    ->hint('rasio kartu identitas landscape')
                    ->image()
                    ->required(),
                Forms\Components\FileUpload::make('background_back')
                    ->disk(config('base_urls.default_disk'))
                    ->directory(fn () => 'card/'.date('Y').'/'.date('m'))
                    ->hint('opsional, sisi belakang kartu')
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_kartu')
                    ->searchable(),
                Tables\Columns\TextColumn::make('instansi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('masa_berlaku_label')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_penandatangan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan_penandatangan')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('background_front')
                    ->disk(config('base_urls.default_disk'))
                    ->simpleLightbox(),
                Tables\Columns\ImageColumn::make('background_back')
                    ->disk(config('base_urls.default_disk'))
                    ->simpleLightbox(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCards::route('/'),
            'create' => Pages\CreateCard::route('/create'),
            'edit' => Pages\EditCard::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            HolderRelationManager::class,
        ];
    }
}
