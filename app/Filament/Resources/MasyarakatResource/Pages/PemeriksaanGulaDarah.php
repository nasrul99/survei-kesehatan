<?php

namespace App\Filament\Resources\MasyarakatResource\Pages;

use App\Filament\Resources\MasyarakatResource;
use App\Models\GulaDarah;
use App\Models\Rekomendasi;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use phpseclib3\Exception\BadConfigurationException;
use Carbon\Carbon;


class PemeriksaanGulaDarah extends ManageRelatedRecords
{
    protected static string $resource = MasyarakatResource::class;

    protected static string $relationship = 'gula_darah';

    protected static ?string $navigationIcon = 'heroicon-o-sun';

    public static function getNavigationLabel(): string
    {
        return 'Gula Darah';
    }

//    public function getSubheading(): ?string
//    {
//        return 'Pemeriksaan Gula Darah a/n ' . $this->record->nama . ' - Divisi ' . $this->record->divisi->nama;
//    }


    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal')
                            ->label('Tanggal Pemeriksaan')
                            ->prefixIcon('heroicon-m-calendar-days')
                            ->native(false)
                            ->closeOnDateSelection()
                            ->required()
                            ->displayFormat('d/m/Y'),
                        Forms\Components\ToggleButtons::make('jenis')
                            ->label('Jenis')
                            ->options(GulaDarah::LBL)
                            ->colors(GulaDarah::WARNA)
                            ->icons(GulaDarah::IKON)
                            ->required()
                            ->inline(),
                        Forms\Components\TextInput::make('hasil')
                            ->label('Hasil')
                            ->numeric()
                            ->minValue(1)
                            ->maxValue(1000)
                            ->required(),
                    ])->columns(2)
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->recordTitleAttribute('tanggal')
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                    ->label('Tanggal')
                    ->searchable()
                    ->sortable()
                    ->formatStateUsing(fn($state) => \Carbon\Carbon::parse($state)->translatedFormat('d-m-Y')),
                Tables\Columns\TextColumn::make('jenis')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('hasil')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('status')->searchable()->sortable(),
                /*
                Tables\Columns\TextColumn::make('rekomendasi.rekomendasi_status')
                    ->html()
                    ->searchable()->sortable(),
                */
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->modalHeading('Input Pemeriksaan Gula Darah')
                    ->mutateFormDataUsing(function (array $data): array {
                        $jenis = $data['jenis'];
                        $hasil = $data['hasil'];

                        if ($hasil < 70) {
                            $data['status'] = "Rendah";
                        } elseif (($jenis == "Puasa" && ($hasil >= 70 && $hasil <= 100))
                            || ($jenis == "Sewaktu" && ($hasil >= 70 && $hasil <= 125))
                            || ($jenis == "Post Prandial" && $hasil < 140)) {
                            $data['status'] = "Normal";
                        } else {
                            $data['status'] = "Tinggi";
                        }
                        $rekomendasi = Rekomendasi::query()
                            ->where('nama_pemeriksaan', 'Gula Darah')
                            ->where('status', $data['status'])
                            ->first();
                        $data['rekomendasi_id'] = $rekomendasi->id;
                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
