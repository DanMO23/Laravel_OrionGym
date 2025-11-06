<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('alunos_personal', function (Blueprint $table) {
            $table->id();
            $table->foreignId('professor_id')->constrained('professores')->onDelete('cascade');
            $table->string('nome_completo');
            $table->enum('tipo_aluno', ['matriculado', 'externo'])->default('externo');
            $table->foreignId('aluno_id')->nullable()->constrained('alunos')->onDelete('set null'); // Se for aluno matriculado
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->date('data_vencimento');
            $table->decimal('valor_mensalidade', 10, 2)->nullable();
            $table->enum('status', ['ativo', 'inativo'])->default('ativo');
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('alunos_personal');
    }
};
