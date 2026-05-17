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
     Schema::create('r_t_p_s', function (Blueprint $table) {
        $table->id();

        $table->foreignId('profil_risiko_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->foreignId('penyebab_risiko_id')
            ->nullable()
            ->constrained()
            ->nullOnDelete();

        $table->string('jenis_rtp')->nullable();

        $table->text('uraian')->nullable();
        $table->text('indikator')->nullable();
        $table->text('berbagi')->nullable();

        $table->string('periode')->nullable();
        $table->string('respon')->nullable();

        $table->text('penanggung_jawab')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('r_t_p_s');
    }
};
