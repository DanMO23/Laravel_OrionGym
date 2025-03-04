<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercicio extends Model
{
    use HasFactory;

    protected $fillable = ['treino_id', 'nome_exercicio', 'series', 'repeticoes_tempo', 'descanso'];

    public function treino()
    {
        return $this->belongsTo(Treino::class);
    }
}
