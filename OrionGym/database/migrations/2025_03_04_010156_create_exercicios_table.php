<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('exercicios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('treino_id')->constrained('treinos')->onDelete('cascade');
            $table->string('nome_exercicio');
            $table->integer('series');
            $table->string('repeticoes_tempo'); // Ex: "10-12 reps" ou "30s"
            $table->string('descanso'); // Ex: "45s"
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('exercicios');
    }
};
