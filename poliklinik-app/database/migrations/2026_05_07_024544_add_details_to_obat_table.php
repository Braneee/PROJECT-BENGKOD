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
        Schema::table('obat', function (Blueprint $table) {
            $table->date('expired')->nullable();
            $table->string('golongan_obat')->nullable();
            $table->string('distributor')->nullable();
            $table->string('produsen_obat')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('obat', function (Blueprint $table) {
            $table->dropColumn(['expired', 'golongan_obat', 'distributor', 'produsen_obat']);
        });
    }
};
