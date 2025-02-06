<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use App\Models\Periode;
use Filament\Forms\Form;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    use BaseDashboard\Concerns\HasFiltersForm;

    protected static ?string $navigationIcon = 'heroicon-o-home';

    /*
    public function filtersForm(Form $form): Form
    {
        // Mengambil ID terakhir dari tabel Periode
        $latestPeriodeId = Periode::latest('id')->value('id');

        return $form
            ->schema([
                Select::make('periode_id')
                    ->label('Filter Periode')
                    ->options(Periode::pluck('tahun', 'id')->toArray()) // Mengambil tahun sebagai label dan id sebagai value
                    ->searchable()  // Opsi pencarian jika data terlalu banyak
                    ->default($latestPeriodeId) // Mengatur default ke periode terakhir
                    ->afterStateHydrated(function (Select $component) use ($latestPeriodeId) {
                        // Menetapkan nilai default secara manual setelah state dihidupkan
                        $component->state($latestPeriodeId);
                    }),

            ]);
    }
    */
}
