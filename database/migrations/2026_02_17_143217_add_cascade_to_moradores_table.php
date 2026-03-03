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
    {        Schema::table('moradors', function (Blueprint $table) {
            $table->dropForeign(['apartamento_id']);
            $table->foreign('apartamento_id')->references('id')->on('apartamentos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('moradors', function (Blueprint $table) {
            $table->dropForeign(['apartamento_id']);
            $table->foreign('apartamento_id')->references('id')->on('apartamentos');
        });
    }
};
