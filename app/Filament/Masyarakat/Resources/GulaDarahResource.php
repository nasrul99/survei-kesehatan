<?php

namespace App\Filament\Masyarakat\Resources;

use App\Filament\Masyarakat\Resources\GulaDarahResource\Pages;
use App\Filament\Masyarakat\Resources\GulaDarahResource\RelationManagers;
use App\Models\GulaDarah;
use App\Models\Masyarakat;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GulaDarahResource extends Resource
{
    protected static ?string $model = GulaDarah::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $pluralLabel = 'Pemeriksaan Gula Darah';
    protected static ?int $navigationSort = 5;
    protected static ?string $navigationGroup = 'Pemeriksaan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\DatePicker::make('tanggal')
                    ->default(now()) // Set default ke tanggal hari ini
                    ->required(),
                Forms\Components\Select::make('jenis')
                    ->options(GulaDarah::LBL) // Menggunakan opsi yang sesuai
                    ->required(),
                Forms\Components\TextInput::make('hasil')
                    ->required()
                    ->numeric(),
            ]);
    }

    public static function table(Table $table): Table
    {
        $masyarakat = Masyarakat::with('user')->where('user_id', auth()->id())->firstOrFail();

        return $table
            ->query(
                GulaDarah::query()
                    ->where('masyarakat_id', '=', $masyarakat->id)
            )
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('tanggal')
                    ->date()
                    ->formatStateUsing(fn($state) => Carbon::parse($state)->locale('id')->isoFormat('DD/MM/YY'))
                    ->sortable(),
                Tables\Columns\TextColumn::make('jenis'),
                Tables\Columns\TextColumn::make('hasil')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable()
                    ->searchable()
                    ->sortable(),
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
            'index' => Pages\ListGulaDarahs::route('/'),
            'create' => Pages\CreateGulaDarah::route('/create'),
            'edit' => Pages\EditGulaDarah::route('/{record}/edit'),
        ];
    }
}
