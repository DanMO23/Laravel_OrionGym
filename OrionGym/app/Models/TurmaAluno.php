<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurmaAluno extends Model
{
    use HasFactory;

    protected $fillable = [
        'turma_id',
        'nome_aluno',
    ];

    public function turma()
    {
        return $this->belongsTo(Turma::class);
    }
}
