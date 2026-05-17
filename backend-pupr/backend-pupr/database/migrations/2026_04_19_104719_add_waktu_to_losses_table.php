<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('losses', function (Blueprint $table) {

            if (!Schema::hasColumn('losses', 'waktu')) {
                $table->date('waktu')->nullable();
            }

        });
    }

    public function down(): void
    {
        Schema::table('losses', function (Blueprint $table) {

            if (Schema::hasColumn('losses', 'waktu')) {
                $table->dropColumn('waktu');
            }

        });
    }
};