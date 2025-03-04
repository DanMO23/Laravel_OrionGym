<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FichaTreino extends Model
{
    use HasFactory;

    protected $table = 'fichas_treino';

    protected $fillable = ['nome_aluno', 'nome_ficha'];

    public function treinos()
    {
        return $this->hasMany(Treino::class);
    }

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }
}
