<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlunoAvaliacoesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aluno_avaliacoes', function (Blueprint $table) {
            $table->id(); // ID da avaliação
            $table->string('nome'); // Nome da pessoa que realizou a avaliação
            $table->string('cpf'); // CPF da pessoa
            $table->date('data_avaliacao'); // Data da avaliação
            $table->time('horario_avaliacao'); // Horário da avaliação
            $table->text('descricao_pagamento')->nullable(); // Descrição do pagamento
            $table->timestamps(); // Campos created_at e updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aluno_avaliacoes');
    }
}
