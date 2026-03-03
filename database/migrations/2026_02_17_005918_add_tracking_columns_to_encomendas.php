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
        Schema::table('encomendas', function (Blueprint $table) {
            $table->foreignId('notificado_por_id')->nullable()->constrained('users');
            $table->foreignId('entregue_por_id')->nullable()->constrained('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('encomendas', function (Blueprint $table) {
            $table->dropForeign(['notificado_por_id']);
            $table->dropColumn('notificado_por_id');
            $table->dropForeign(['entregue_por_id']);
            $table->dropColumn('entregue_por_id');
        });
    }
};
