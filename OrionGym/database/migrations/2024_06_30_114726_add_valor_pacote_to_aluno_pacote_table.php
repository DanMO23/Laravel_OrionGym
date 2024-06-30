<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('aluno_pacote', function (Blueprint $table) {
            $table->decimal('valor_pacote', 8, 2)->after('descricao_pagamento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('aluno_pacote', function (Blueprint $table) {
            $table->dropColumn('valor_pacote');
        });
    }
};
