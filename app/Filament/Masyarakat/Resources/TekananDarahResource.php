<?php

namespace App\Filament\Masyarakat\Resources;

use App\Filament\Masyarakat\Resources\TekananDarahResource\Pages;
use App\Filament\Masyarakat\Resources\TekananDarahResource\RelationManagers;
use App\Models\AsamUrat;
use App\Models\Masyarakat;
use App\Models\TekananDarah;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TekananDarahResource extends Resource
{
    protected static ?string $model = TekananDarah::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $pluralLabel = 'Pemeriksaan Tekanan Darah';
    protected static ?int $navigationSort = 4;
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
                        Forms\Components\TextInput::make('sistole')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('diastole')
                            ->required()
                            ->numeric(),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        $masyarakat = Masyarakat::with('user')->where('user_id', auth()->id())->firstOrFail();

        return $table
            ->query(
                TekananDarah::query()
                    ->where('masyarakat_id', '=', $masyarakat->id)
            )
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->locale('id')->isoFormat('DD/MM/YY'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('sistole')
                    ->numeric()
                    ->label('Sistole/TDS')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('diastole')
                    ->numeric()
                    ->label('Diastole/TDD')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('rekomendasi.rekomendasi_status')
                    ->numeric()
                    ->html()
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
            'index' => Pages\ListTekananDarahs::route('/'),
            'create' => Pages\CreateTekananDarah::route('/create'),
            'edit' => Pages\EditTekananDarah::route('/{record}/edit'),
        ];
    }
}
