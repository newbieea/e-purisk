<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
      Schema::create('penyebab_risikos', function (Blueprint $table) {
        $table->id();

        $table->foreignId('profil_risiko_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('kode');
        $table->string('jenis');

        $table->text('penyebab');
        $table->text('pengendalian')->nullable();

        $table->string('status')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penyebab_risikos');
    }
};
