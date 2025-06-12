<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CertificateResource\Pages;
use App\Filament\Resources\CertificateResource\RelationManagers;
use App\Models\Certificate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CertificateResource extends Resource
{
    protected static ?string $model = Certificate::class;

    protected static ?string $navigationIcon = 'heroicon-o-trophy';

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
                Forms\Components\TextInput::make('jenis')
                    ->label('Judul Sertifikat')
                    ->hint('misal: Sertifikat Pelatihan')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('prefix_nomor')
                    ->label('Suffix Penomoran')
                    ->hint('misal: /ORG/XII/01/2025')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\Textarea::make('deskripsi')
                    ->hint('misal: telah mengikuti pelatihan pada...')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('lokasi')
                    ->hint('misal: Bandung')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('tanggal_terbit')
                    ->hint('misal: 10 Januari 2025')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('nama_penandatangan')
                    ->hint('misal: Lorem Ipsum, PhD')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('jabatan_penandatangan')
                    ->hint('misal: Direktur Lembaga')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\FileUpload::make('file_tandatangan')
                    ->hint('saran: background png transparan')
                    ->disk(config('base_urls.default_disk'))
                    ->directory(fn () => 'cert/'.date('Y').'/'.date('m'))
                    ->image()
                    ->required(),
                Forms\Components\FileUpload::make('background_image')
                    ->hint('gambar ukuran A4 landscape')
                    ->disk(config('base_urls.default_disk'))
                    ->directory(fn () => 'cert/'.date('Y').'/'.date('m'))
                    ->image()
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('jenis')
                    ->searchable(),
                Tables\Columns\TextColumn::make('prefix_nomor')
                    ->label('Suffix')
                    ->searchable(),
                Tables\Columns\TextColumn::make('lokasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('tanggal_terbit')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_penandatangan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan_penandatangan')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('file_tandatangan')
                    ->simpleLightbox(),
                Tables\Columns\ImageColumn::make('background_image')
                    ->simpleLightbox(),
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCertificates::route('/'),
            'create' => Pages\CreateCertificate::route('/create'),
            'edit' => Pages\EditCertificate::route('/{record}/edit'),
        ];
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ParticipantRelationManager::class,
        ];
    }
}
