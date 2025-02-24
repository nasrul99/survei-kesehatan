<?php

namespace App\Filament\Resources\MasyarakatResource\Pages;

use App\Filament\Resources\MasyarakatResource;
use App\Models\AsamUrat;
use App\Models\Masyarakat;
use App\Models\Rekomendasi;
use Filament\Actions;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\ManageRelatedRecords;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;


class PemeriksaanAsamUrat extends ManageRelatedRecords
{
    protected static string $resource = MasyarakatResource::class;

    protected static string $relationship = 'asam_urat';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function getNavigationLabel(): string
    {
        return 'Asam Urat';
    }

//    public function getSubheading(): ?string
//    {
//        return 'Pemeriksaan Asam Urat a/n ' . $this->record->nama . ' - Divisi ' . $this->record->divisi->nama;
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
                        Forms\Components\TextInput::make('hasil')
                            ->label('Hasil')
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
                    ->modalHeading('Input Pemeriksaan Asam Urat')
                    ->mutateFormDataUsing(function (array $data): array {
                        // Akses masyarakat dari getOwnerRecord()
                        $peg = $this->getOwnerRecord(); // Mendapatkan record masyarakat terkait

                        if (!$peg) {
                            throw new \Exception("Masyarakat tidak ditemukan.");
                        }

                        //$data['status'] = $data['hasil'] <= 5 ? "Normal" : "Tinggi";
                        if ($peg->gender == 'L') {
                            if ($data['hasil'] < 3.4) $data['status'] = "Rendah";
                            else if ($data['hasil'] >= 3.4 && $data['hasil'] <= 7.0) $data['status'] = "Normal";
                            else $data['status'] = "Tinggi";
                        } else {
                            if ($data['hasil'] < 2.4) $data['status'] = "Rendah";
                            else if ($data['hasil'] >= 2.4 && $data['hasil'] <= 6.0) $data['status'] = "Normal";
                            else $data['status'] = "Tinggi";
                        }
                        $rekomendasi = Rekomendasi::query()
                            ->where('nama_pemeriksaan', 'Asam Urat')
                            ->where('status', $data['status'])
                            ->first();
                        //dd($ids);
                        $data['rekomendasi_id'] = $rekomendasi->id;
                        return $data;
                    }),
            ])
            ->actions([
                //Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()
                    ->modalHeading('Ubah Pemeriksaan Asam Urat')
                    ->mutateFormDataUsing(function (array $data): array {
                        // Akses masyarakat dari getOwnerRecord()
                        $peg = $this->getOwnerRecord(); // Mendapatkan record masyarakat terkait

                        if (!$peg) {
                            throw new \Exception("Masyarakat tidak ditemukan.");
                        }

                        //$data['status'] = $data['hasil'] <= 5 ? "Normal" : "Tinggi";
                        if ($peg->gender == 'L') {
                            if ($data['hasil'] < 3.4) $data['status'] = "Rendah";
                            else if ($data['hasil'] >= 3.4 && $data['hasil'] <= 7.0) $data['status'] = "Normal";
                            else $data['status'] = "Tinggi";
                        } else {
                            if ($data['hasil'] < 2.4) $data['status'] = "Rendah";
                            else if ($data['hasil'] >= 2.4 && $data['hasil'] <= 6.0) $data['status'] = "Normal";
                            else $data['status'] = "Tinggi";
                        }
                        $rekomendasi = Rekomendasi::query()
                            ->where('nama_pemeriksaan', 'Asam Urat')
                            ->where('status', $data['status'])
                            ->first();
                        //dd($ids);
                        $data['rekomendasi_id'] = $rekomendasi->id;
                        return $data;
                    }),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
