<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('encomendas', function (Blueprint $table) {
            // Adicionando como nullable para evitar erro se houver dados antigos
            $table->foreignId('condominio_id')
                  ->after('id')
                  ->nullable() 
                  ->constrained()
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('encomendas', function (Blueprint $table) {
            // Sempre remova a Foreign Key antes da Column
            $table->dropForeign(['condominio_id']);
            $table->dropColumn('condominio_id');
        });
    }
};