<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlunoAvaliacao extends Model
{
    use HasFactory;

    protected $table = 'aluno_avaliacoes';

    protected $fillable = [
        'nome', 'cpf', 'data_avaliacao', 'horario_avaliacao', 'descricao_pagamento', 'status', 'telefone', 'valor_avaliacao'
    ];
    
}
