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
            $table->string('status')->default('pendente')->change();
            if (!Schema::hasColumn('encomendas', 'notificado_em')) {
                $table->timestamp('notificado_em')->nullable()->after('status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('encomendas', function (Blueprint $table) {
            $table->dropColumn('notificado_em');
        });
    }
};
