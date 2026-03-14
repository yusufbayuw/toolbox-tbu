<?php

namespace App\Filament\Resources\CardResource\RelationManagers;

use App\Models\CardHolder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class HolderRelationManager extends RelationManager
{
    protected static string $relationship = 'holders';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('card_id')
                    ->default($this->ownerRecord->id),
                Forms\Components\TextInput::make('nomor_identitas')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('nama_pemegang')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('jabatan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('instansi')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\TextInput::make('masa_berlaku')
                    ->hint('misal: 31 Desember 2026')
                    ->maxLength(255)
                    ->default(null),
                Forms\Components\FileUpload::make('foto')
                    ->disk(config('base_urls.default_disk'))
                    ->directory(fn () => 'card/'.date('Y').'/'.date('m').'/photo')
                    ->image()
                    ->imageEditor(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_pemegang')
            ->columns([
                Tables\Columns\ImageColumn::make('foto')
                    ->disk(config('base_urls.default_disk'))
                    ->circular(),
                Tables\Columns\TextColumn::make('nomor_identitas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('nama_pemegang')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jabatan')
                    ->searchable(),
                Tables\Columns\ImageColumn::make('qrcode_val')
                    ->disk(config('base_urls.default_disk'))
                    ->simpleLightbox()
                    ->label('QR Validation'),
                Tables\Columns\TextColumn::make('uuid')
                    ->label('Link')
                    ->formatStateUsing(fn () => 'LINK')
                    ->url(fn ($state) => config('base_urls.base_card').'/'.$state, true),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\Action::make('import')
                    ->form([
                        Forms\Components\FileUpload::make('file')
                            ->disk(config('base_urls.default_disk'))
                            ->directory('temp_upload')
                            ->label('Upload CSV File')
                            ->acceptedFileTypes(['text/csv', 'text/plain', 'application/vnd.ms-excel'])
                            ->required()
                            ->storeFiles(true),
                    ])
                    ->action(function (array $data): void {
                        $filePath = public_path('storage/'.$data['file']);
                        $rows = array_map('str_getcsv', file($filePath));
                        $header = array_shift($rows);
                        $holders = array_map(
                            fn ($row) => array_combine($header, $row),
                            $rows
                        );

                        foreach ($holders as $holder) {
                            CardHolder::create([
                                'card_id' => $this->ownerRecord->id,
                                'nomor_identitas' => $holder['nomor_identitas'] ?? null,
                                'nama_pemegang' => $holder['nama_pemegang'] ?? null,
                                'jabatan' => $holder['jabatan'] ?? null,
                                'instansi' => $holder['instansi'] ?? null,
                                'masa_berlaku' => $holder['masa_berlaku'] ?? null,
                            ]);
                        }
                    })
                    ->color('success'),
                Tables\Actions\Action::make('template')
                    ->label('Template CSV')
                    ->icon('heroicon-m-document-arrow-down')
                    ->url(url('files/card_holder_upload_template.csv'))
                    ->openUrlInNewTab(),
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
}
