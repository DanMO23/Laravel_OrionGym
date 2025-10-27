<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aluno_pacote', function (Blueprint $table) {
            // Alterando a coluna para permitir valores nulos
            $table->unsignedBigInteger('pacote_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aluno_pacote', function (Blueprint $table) {
            // Revertendo a alteração, caso necessário
            $table->unsignedBigInteger('pacote_id')->nullable(false)->change();
        });
    }
};
