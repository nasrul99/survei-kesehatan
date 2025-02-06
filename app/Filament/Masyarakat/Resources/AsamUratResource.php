<?php

namespace App\Filament\Masyarakat\Resources;

use App\Filament\Masyarakat\Resources\AsamUratResource\Pages;
use App\Filament\Masyarakat\Resources\AsamUratResource\RelationManagers;
use App\Models\AsamUrat;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Carbon\Carbon;
use Filament\Tables\Columns\TextColumn;

class AsamUratResource extends Resource
{
    protected static ?string $model = AsamUrat::class;

    protected static ?string $label = 'Asam Urat';

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $pluralLabel = 'Pemeriksaan Asam Urat';
    protected static ?int $navigationSort = 2;
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
//                Tables\Columns\TextColumn::make('masyarakat_id')
//                    ->numeric()
//                    ->sortable(),
                Tables\Columns\TextColumn::make('hasil')
                    ->numeric()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('rekomendasi.rekomendasi_status')
                    ->numeric()
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
            'index' => Pages\ListAsamUrats::route('/'),
            'create' => Pages\CreateAsamUrat::route('/create'),
            'edit' => Pages\EditAsamUrat::route('/{record}/edit'),
        ];
    }
}
