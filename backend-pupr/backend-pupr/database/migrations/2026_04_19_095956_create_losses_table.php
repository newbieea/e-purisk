<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('losses', function (Blueprint $table) {
            $table->id();
            $table->string('sumber')->nullable();
            $table->date('tanggalCatat')->nullable();
            $table->text('uraian')->nullable();
            $table->string('waktu')->nullable();
            $table->string('lokasi')->nullable();
            $table->text('sebab')->nullable();
            $table->text('kondisi')->nullable();
            $table->text('dampak')->nullable();
            $table->text('rincian')->nullable();
            $table->string('unit')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('losses');
    }
};