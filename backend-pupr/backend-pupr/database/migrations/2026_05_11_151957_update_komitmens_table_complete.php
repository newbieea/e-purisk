<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('komitmens', function (Blueprint $table) {

            if (!Schema::hasColumn('komitmens', 'level')) {
                $table->string('level')->nullable();
            }

            if (!Schema::hasColumn('komitmens', 'anggaran')) {
                $table->string('anggaran')->nullable();
            }

            if (!Schema::hasColumn('komitmens', 'link')) {
                $table->text('link')->nullable();
            }

            if (!Schema::hasColumn('komitmens', 'status')) {
                $table->string('status')->nullable();
            }

        });
    }

    public function down(): void
    {
        Schema::table('komitmens', function (Blueprint $table) {

            $table->dropColumn([
                'level',
                'anggaran',
                'link',
                'status'
            ]);

        });
    }
};