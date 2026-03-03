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
        Schema::table('condominios', function (Blueprint $table) {
            if (!Schema::hasColumn('condominios', 'unidades_por_andar')) {
                $table->integer('unidades_por_andar')->default(4)->after('andares_por_bloco');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('condominios', function (Blueprint $table) {
            $table->dropColumn('unidades_por_andar');
        });
    }
};
