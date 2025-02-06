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
        Schema::create('fisik', function (Blueprint $table) {
            $table->id();
            $table->date('tanggal');
            $table->foreignId('masyarakat_id')->constrained('masyarakat')->onDelete('cascade');
            $table->double('berat_badan');
            $table->double('tinggi_badan');
            $table->double('imt')->nullable();
            $table->string('kondisi_fisik')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fisik');
    }
};
