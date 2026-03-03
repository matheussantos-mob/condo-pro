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
        Schema::create('encomendas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartamento_id')->constrained();
            $table->string('descricao');
            $table->string('setor_estoque');
            $table->string('codigo_retirada', 4);
            $table->enum('status', ['pendente', 'entregue'])->default('pendente');
            $table->string('recebido_por');
            $table->string('retirado_por')->nullable();
            $table->timestamp('entregue_em')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encomendas');
    }
};
