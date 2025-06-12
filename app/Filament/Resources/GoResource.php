<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GoResource\Pages;
use App\Filament\Resources\GoResource\RelationManagers;
use App\Models\Go;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GoResource extends Resource
{
    protected static ?string $model = Go::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-uturn-right';

    protected static ?string $modelLabel = 'Go Redirect';

    protected static ?string $slug = 'go';

    public static function getEloquentQuery(): Builder
    {
        if (auth()->user()->hasRole(['super_admin'])) {
            return parent::getEloquentQuery();
        } else {
            return parent::getEloquentQuery()->where('user_id', auth()->user()->id);
        }
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->user()->id),
                Forms\Components\TextInput::make('original_link')
                    ->required()
                    ->url()
                    ->maxLength(255),
                Forms\Components\TextInput::make('short_link')
                    ->required()
                    ->unique(ignoreRecord:true)
                    ->maxLength(255)
                    ->prefix(config('base_urls.base_go').'/'),
                Forms\Components\FileUpload::make('logo')
                    ->disk(config('base_urls.default_disk'))
                    ->directory(fn () => 'go/'.date('Y').'/'.date('m'))
                    ->image(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('short_link')
                    ->searchable()
                    ->label('Short Link')
                    //->url(fn (string $state): string => config('base_urls.base_go') . '/' . $state, true)
                    ->formatStateUsing(fn ($state) => config('base_urls.base_go') . '/' . $state)
                    ->copyable()
                    ->copyMessage('Link Disalin')
                    ->copyableState(fn (string $state): string => config('base_urls.base_go') . '/' . $state),
                Tables\Columns\TextColumn::make('original_link')
                    ->searchable()
                    ->label('Original')
                    ->formatStateUsing(fn ($state) => parse_url($state, PHP_URL_HOST))
                    ->wrap(),
                Tables\Columns\ImageColumn::make('logo')
                    ->disk(config('base_urls.default_disk'))
                    ->simpleLightbox(fn ($record) => env('R2_URL').$record->logo)
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\ImageColumn::make('qr_code_image')
                    ->disk(config('base_urls.default_disk'))
                    ->simpleLightbox(fn ($record) => env('R2_URL').$record->qr_code_image),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
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
            'index' => Pages\ManageGos::route('/'),
        ];
    }
}
