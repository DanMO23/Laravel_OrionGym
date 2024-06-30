<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlunosVencidos extends Model
{
    use HasFactory;

    protected $fillable = ['aluno_id', 'nome', 'email', 'telefone', 'sexo', 'numero_matricula', 'matricula_ativa'];
}
