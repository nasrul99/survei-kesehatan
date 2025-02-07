<?php

namespace App\Filament\Masyarakat\Resources;

use App\Filament\Masyarakat\Resources\FisikResource\Pages;
use App\Filament\Masyarakat\Resources\FisikResource\RelationManagers;
use App\Models\Fisik;
use App\Models\Masyarakat;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class FisikResource extends Resource
{
    protected static ?string $model = Fisik::class;

    protected static ?string $navigationIcon = 'heroicon-o-face-smile';
    protected static ?string $pluralLabel = 'Pemeriksaan BMI';
    protected static ?int $navigationSort = 1;
    protected static ?string $navigationGroup = 'Pemeriksaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->schema([
                        Forms\Components\DatePicker::make('tanggal')
                            ->required(),
                        //                Forms\Components\Select::make('masyarakat_id')
                        //                    ->relationship('masyarakat', 'id')
                        //                    ->required(),
                        Forms\Components\TextInput::make('berat_badan')
                            ->label('Berat Badan')
                            ->required()
                            ->numeric(),
                        Forms\Components\TextInput::make('tinggi_badan')
                            ->label('Tinggi Badan')
                            ->required()
                            ->numeric(),
//                        Forms\Components\TextInput::make('imt')
//                            ->label('IMT')
//                            ->numeric()
//                            ->default(null),
//                        Forms\Components\TextInput::make('kondisi_fisik')
//                            ->label('Kondisi Fisik')
//                            ->maxLength(255)
//                            ->default(null),
                    ])->columns(2)
            ]);
    }

    public static function table(Table $table): Table
    {
        $masyarakat = Masyarakat::with('user')->where('user_id', auth()->id())->firstOrFail();

        return $table
            ->query(
                Fisik::query()
                    ->where('masyarakat_id', '=', $masyarakat->id)
            )
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->locale('id')->isoFormat('DD/MM/YY'))
                    ->sortable(),
//                Tables\Columns\TextColumn::make('masyarakat.id')
//                    ->numeric()
//                    ->sortable(),
                Tables\Columns\TextColumn::make('berat_badan')
                    ->label('Berat Badan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tinggi_badan')
                    ->label('Tinggi Badan')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('imt')
                    ->label('BMI')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('kondisi_fisik')
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListFisiks::route('/'),
            'create' => Pages\CreateFisik::route('/create'),
            'edit' => Pages\EditFisik::route('/{record}/edit'),
        ];
    }
}
