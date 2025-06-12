<?php

namespace App\Filament\Resources\CertificateResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ParticipantRelationManager extends RelationManager
{
    protected static string $relationship = 'participant';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('certificate_id')
                    ->default($this->ownerRecord->id),
                Forms\Components\TextInput::make('nomor')
                    ->numeric()
                    ->required(),
                Forms\Components\TextInput::make('nama_penerima')
                    ->maxLength(255)
                    ->required(),
                Forms\Components\TextInput::make('asal_penerima')
                    ->maxLength(255)
                    ->default(null),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('nama_penerima')
            ->columns([
                Tables\Columns\TextColumn::make('nomor'),
                Tables\Columns\TextColumn::make('nama_penerima'),
                Tables\Columns\TextColumn::make('asal_penerima'),
                Tables\Columns\TextColumn::make('asal_penerima'),
                Tables\Columns\TextColumn::make('uuid')
                    ->label('Link')
                    ->formatStateUsing(fn() => "LINK")
                    ->url(fn($state) => config("base_urls.base_cert") . "/{$state}", true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
                Tables\Actions\Action::make('import')
                    ->form([
                        Forms\Components\FileUpload::make('file')
                            ->disk(config('base_urls.default_disk'))
                            ->directory('temp_upload')
                            ->label('Upload CSV File')
                            ->required()
                            ->acceptedFileTypes(['text/csv', 'text/plain', 'application/vnd.ms-excel'])
                            ->storeFiles(true),
                    ])
                    ->action(function (array $data) {
                        $file = $data['file'];
                        $filePath = public_path("storage/{$file}");

                        // Read the CSV file
                        $rows = array_map('str_getcsv', file($filePath));
                        $header = array_shift($rows);

                        // Convert rows to associative arrays
                        $participants = array_map(function ($row) use ($header) {
                            return array_combine($header, $row);
                        }, $rows);

                        // Get the owner certificate ID
                        $certificateId = $this->ownerRecord->id;

                        // Insert participants with certificate_id
                        foreach ($participants as $participant) {
                            \App\Models\CertificateParticipant::create([
                                'certificate_id' => $certificateId,
                                'nomor' => $participant['nomor'],
                                'nama_penerima' => $participant['nama_penerima'],
                                'asal_penerima' => $participant['asal_penerima'],
                            ]);
                        }
                    })
                    ->color('success'),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\Action::make('upload')
                        ->label('Upload CSV')
                        ->icon('heroicon-m-document-arrow-down')
                        ->url(url('files/cert_participant_upload_template.csv')) // Generate the URL to the file
                        ->openUrlInNewTab(), // Optionally, open in a new tab
                    Tables\Actions\Action::make('background')
                        ->label('Background Image')
                        ->icon('heroicon-m-arrow-down-tray')
                        ->url(url('images/certificate_template.png')) // Generate the URL to the file
                        ->openUrlInNewTab(),
                ])
                    ->label('Template')
                    ->icon('heroicon-m-ellipsis-vertical')
                    ->color('danger')
                    ->button(),
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
