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
        Schema::table('aluno_avaliacoes', function (Blueprint $table) {
            $table->string('telefone');
            $table->decimal('valor_avaliacao', 8, 2)->default(50.00);
        });
    }

    public function down()
    {
        Schema::table('aluno_avaliacoes', function (Blueprint $table) {
            $table->dropColumn('telefone');
            $table->dropColumn('valor_avaliacao');
        });
    }
};
