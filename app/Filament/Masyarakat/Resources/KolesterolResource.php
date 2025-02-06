<?php

namespace App\Filament\Masyarakat\Resources;

use App\Filament\Masyarakat\Resources\KolesterolResource\Pages;
use App\Filament\Masyarakat\Resources\KolesterolResource\RelationManagers;
use App\Models\Kolesterol;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class KolesterolResource extends Resource
{
    protected static ?string $model = Kolesterol::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $pluralLabel = 'Pemeriksaan Kolesterol';
    protected static ?int $navigationSort = 3;
    protected static ?string $navigationGroup = 'Pemeriksaan';

    public static function form(Form $form): Form
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


    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->locale('id')->isoFormat('DD/MM/YY'))
                    ->sortable(),
//                Tables\Columns\TextColumn::make('masyarakat.id')
//                    ->numeric()
//                    ->sortable(),
                Tables\Columns\TextColumn::make('hasil')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('rekomendasi.rekomendasi_status')
                    ->numeric()
                    ->html()
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListKolesterols::route('/'),
            'create' => Pages\CreateKolesterol::route('/create'),
            'edit' => Pages\EditKolesterol::route('/{record}/edit'),
        ];
    }
}
