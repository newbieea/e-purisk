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
        Schema::create('komitmens', function (Blueprint $table) {

            $table->id();

            $table->string('unit')->nullable();
            $table->string('level')->nullable();
            $table->string('periode')->nullable();

            $table->bigInteger('anggaran')->default(0);

            // PEMILIK
            $table->string('pemilik')->nullable();
            $table->string('jabatan_pemilik')->nullable();
            $table->string('nip_pemilik')->nullable();

            // PENGELOLA
            $table->string('pengelola')->nullable();
            $table->string('jabatan_pengelola')->nullable();
            $table->string('nip_pengelola')->nullable();

            // TAMBAHAN FRONTEND
            $table->longText('pakta')->nullable();
            $table->longText('tujuan')->nullable();

            $table->string('status')
                ->default('Pending');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('komitmens');
    }
};
