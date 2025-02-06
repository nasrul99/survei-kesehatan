<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table(
            'tekanan_darah',
            function (Blueprint $table) {
                $table->dropColumn('status');
            }
        );

        Schema::table('tekanan_darah', function (Blueprint $table) {
            $table->enum('status',
                [
                    'Normal',
                    'Pra-hipertensi',
                    'Hipertensi Tingkat 1',
                    'Hipertensi Tingkat 2',
                    'Hipertensi Sistolik Terisolasi'
                ]);
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
