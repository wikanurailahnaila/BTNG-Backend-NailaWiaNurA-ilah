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
    Schema::table('mobils', function (Blueprint $table) {
        if (! Schema::hasColumn('mobils', 'warna')) {
            $table->string('warna')->nullable();
        }
        if (! Schema::hasColumn('mobils', 'kilometer')) {
            $table->integer('kilometer')->default(0);
        }
        if (! Schema::hasColumn('mobils', 'plat_nomor')) {
            $table->string('plat_nomor')->nullable();
        }
        if (! Schema::hasColumn('mobils', 'deskripsi')) {
            $table->text('deskripsi')->nullable();
        }
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mobils', function (Blueprint $table) {
            //
        });
    }
};
