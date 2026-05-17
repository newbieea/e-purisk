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
        Schema::create('profil_risikos', function (Blueprint $table) {

            $table->id();

            $table->foreignId('komitmen_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('paket_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->string('kode');

            $table->string('kategori')->nullable();
            $table->string('kegiatan')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('tahapan')->nullable();

            $table->text('pernyataan')->nullable();

            $table->text('dampak')->nullable();

            $table->string('dampak_kategori')
                ->nullable();

            $table->text('penanggung_jawab')
                ->nullable();

            $table->integer('k')->default(1);
            $table->integer('d')->default(1);
            $table->integer('skor')->default(1);

            $table->string('prioritas')->nullable();

            $table->string('respon')->nullable();

            $table->integer('rtp_k')->nullable();
            $table->integer('rtp_d')->nullable();
            $table->integer('rtp_n')->nullable();

            $table->text('sumber')->nullable();

            $table->string('klasifikasi')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profil_risikos');
    }
};