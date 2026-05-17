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
         Schema::create('target_r_t_p_s', function (Blueprint $table) {
        $table->id();

        $table->foreignId('rtp_id')
            ->constrained('r_t_p_s')
            ->cascadeOnDelete();

        $table->date('waktu');
        $table->text('uraian')->nullable();

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('target_r_t_p_s');
    }
};
