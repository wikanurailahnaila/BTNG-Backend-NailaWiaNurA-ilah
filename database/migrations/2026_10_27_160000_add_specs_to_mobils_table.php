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
            $table->string('warna')->after('foto')->nullable();
            $table->unsignedInteger('kilometer')->after('warna')->default(0);
            $table->string('plat_nomor', 12)->after('kilometer')->nullable();
            $table->text('deskripsi')->after('plat_nomor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mobils', function (Blueprint $table) {
            $table->dropColumn(['warna', 'kilometer', 'plat_nomor', 'deskripsi']);
        });
    }
};
