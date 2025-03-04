<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('treinos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ficha_treino_id')->constrained('fichas_treino')->onDelete('cascade');
            $table->string('nome_treino'); // Ex: "A", "B", "C", "D"
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('treinos');
    }
};
