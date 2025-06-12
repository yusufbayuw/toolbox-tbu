<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QrResource\Pages;
use App\Filament\Resources\QrResource\RelationManagers;
use App\Models\Qr;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QrResource extends Resource
{
    protected static ?string $model = Qr::class;

    protected static ?string $navigationIcon = 'heroicon-o-qr-code';

    protected static ?string $modelLabel = 'QRCode Maker';

    protected static ?string $slug = 'qr';

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
                Forms\Components\Hidden::make('user_id')
                    ->default(auth()->user()->id),
                ...\LaraZeus\Qr\Facades\Qr::getFormSchema('qr_code', 'options'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('qr_code')
                    ->label('Konten')
                    ->searchable(),
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQrs::route('/'),
            'create' => Pages\CreateQr::route('/create'),
            'edit' => Pages\EditQr::route('/{record}/edit'),
        ];
    }
}
