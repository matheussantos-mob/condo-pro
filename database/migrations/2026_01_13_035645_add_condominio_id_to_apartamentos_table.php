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
        Schema::table('apartamentos', function (Blueprint $table) {
           $table->foreignId('condominio_id')->nullable()->constrained('condominios')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apartamentos', function (Blueprint $table) {
            $table->dropForeign(['condominio_id']);
            $table->dropColumn('condominio_id');
        });
    }
};
