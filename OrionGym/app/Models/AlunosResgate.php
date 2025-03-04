<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlunosResgate extends Model
{
    use HasFactory;

    protected $table = 'alunos_resgate';

    protected $fillable = [
        'nome',
        'email',
        'telefone',
                'numero_matricula',
        'matricula_ativa',
    ];
}