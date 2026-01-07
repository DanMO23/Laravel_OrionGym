<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Turma extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'dia_semana',
        'horario',
        'nome_professor',
    ];

    public function alunos()
    {
        return $this->hasMany(TurmaAluno::class);
    }
}
