<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $fillable = ['nome', 'email', 'telefone', 'data_nascimento', 'cpf', 'sexo', 'endereco'];

    public function pacotes()
    {
        return $this->belongsToMany(Pacote::class, 'aluno_pacote')->withPivot('descricao_pagamento');
    }
}

