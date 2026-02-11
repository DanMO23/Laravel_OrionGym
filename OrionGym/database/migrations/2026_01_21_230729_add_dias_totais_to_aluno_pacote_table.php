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
        Schema::table('aluno_pacote', function (Blueprint $table) {
            $table->integer('dias_totais')->nullable()->after('valor_pacote');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('aluno_pacote', function (Blueprint $table) {
            $table->dropColumn('dias_totais');
        });
    }
};
