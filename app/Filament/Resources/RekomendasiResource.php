<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RekomendasiResource\Pages;
use App\Filament\Resources\RekomendasiResource\RelationManagers;
use App\Models\Rekomendasi;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RekomendasiResource extends Resource
{
    protected static ?string $model = Rekomendasi::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $pluralLabel = 'Rekomendasi';
    protected static ?int $navigationSort = 2;
    protected static ?string $navigationGroup = 'Skrining Kesehatan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('nama_pemeriksaan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\ToggleButtons::make('status')
                    ->label('Status')
                    ->options(Rekomendasi::LABELS)
                    ->colors(Rekomendasi::COLORS)
                    ->icons(Rekomendasi::ICONS)
                    ->inline(),
                Forms\Components\RichEditor::make('rekomendasi_status')
                    ->label('Rekomendasi Status')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('id', 'desc')
            ->columns([
                Tables\Columns\TextColumn::make('nama_pemeriksaan')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->icon(fn(string $state): string => match ($state) {
                        'Rendah' => 'heroicon-m-arrow-down-circle',
                        'Normal' => 'heroicon-m-check-circle',
                        'Tinggi' => 'heroicon-m-arrow-up-circle',
                        default => 'heroicon-m-check-circle',
                    })
                    ->color(fn(string $state): string => match ($state) {
                        'Rendah' => 'warning',
                        'Normal' => 'success',
                        'Tinggi' => 'danger',
                        default => 'success',
                    })->searchable()->sortable(),
                Tables\Columns\TextColumn::make('rekomendasi_status')
                    ->label('Rekomendasi Status')
                    ->html()
                    ->searchable()
                    ->alignLeft(),
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
            'index' => Pages\ListRekomendasis::route('/'),
            'create' => Pages\CreateRekomendasi::route('/create'),
            'edit' => Pages\EditRekomendasi::route('/{record}/edit'),
        ];
    }
}
