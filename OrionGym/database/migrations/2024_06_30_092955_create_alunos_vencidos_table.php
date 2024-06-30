<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlunosVencidosTable extends Migration
{
    public function up()
    {
        Schema::create('alunos_vencidos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aluno_id');

            $table->string('nome');
            $table->string('email')->nullable();
            $table->string('telefone');
            $table->string('sexo');
            $table->string('matricula_ativa')->nullable();
            $table->integer('numero_matricula')->unsigned()->default(0);
            $table->timestamps();

            $table->foreign('aluno_id')->references('id')->on('alunos')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('alunos_vencidos');
    }
}
