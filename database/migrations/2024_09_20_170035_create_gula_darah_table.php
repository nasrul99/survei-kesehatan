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
        Schema::create('gula_darah', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('masyarakat_id')->constrained('masyarakat')->onDelete('cascade');
            $table->enum('jenis', ['Puasa', 'Sewaktu', 'Post Prandial']);
            $table->integer('hasil');
            $table->enum('status', ['Rendah', 'Normal', 'Tinggi']);
            $table->foreignId('rekomendasi_id')->nullable()->constrained('rekomendasi')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gula_darah');
    }
};
