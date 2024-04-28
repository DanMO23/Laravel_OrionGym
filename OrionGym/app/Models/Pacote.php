<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pacote extends Model
{
    protected $fillable = ['nome_pacote', 'valor', 'validade'];
    // app\Models\Pacote.php


    public function alunos()
    {
        return $this->belongsToMany(Aluno::class, 'aluno_pacote')->withPivot('descricao_pagamento');
    }


}
