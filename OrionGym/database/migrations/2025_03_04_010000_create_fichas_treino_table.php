<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('fichas_treino', function (Blueprint $table) {
            $table->id();
            $table->string('nome_aluno');// Adicionando nome do aluno
            $table->string('nome_ficha'); // Ex: "Ficha de Hipertrofia"
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fichas_treino');
    }
};
