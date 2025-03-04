<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treino extends Model
{
    use HasFactory;

    protected $fillable = ['ficha_treino_id', 'nome_treino'];

    public function fichaTreino()
    {
        return $this->belongsTo(FichaTreino::class);
    }

    public function exercicios()
    {
        return $this->hasMany(Exercicio::class);
    }
}

