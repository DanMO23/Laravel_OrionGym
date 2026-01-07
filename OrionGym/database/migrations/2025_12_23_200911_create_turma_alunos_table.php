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
        if (!Schema::hasTable('turma_alunos')) {
            Schema::create('turma_alunos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('turma_id')->constrained('turmas')->onDelete('cascade');
                $table->string('nome_aluno');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turma_alunos');
    }
};
