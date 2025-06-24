<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateParticipantResource\Pages;
use App\Filament\Resources\CertificateParticipantResource\RelationManagers;
use App\Models\CertificateParticipant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CertificateParticipantResource extends Resource
{
    protected static ?string $model = CertificateParticipant::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('certificate_id')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('nomor')
                    ->numeric()
                    ->default(null),
                Forms\Components\TextInput::make('nama_penerima')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('asal_penerima')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('uuid')
                    ->label('UUID')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('uuid_val')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('certificate_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('nomor')
                    ->sortable(),
                Tables\Columns\TextColumn::make('nama_penerima')
                    ->searchable(),
                Tables\Columns\TextColumn::make('asal_penerima')
                    ->searchable(),
                Tables\Columns\TextColumn::make('uuid')
                    ->label('UUID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('uuid_val')
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
            'index' => Pages\ManageCertificateParticipants::route('/'),
        ];
    }
}
