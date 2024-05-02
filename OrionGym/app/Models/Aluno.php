<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aluno extends Model
{
    protected $fillable = ['nome', 'email', 'telefone', 'data_nascimento', 'cpf', 'sexo', 'endereco', 'dias_restantes'];

    public function pacotes()
    {
        return $this->belongsToMany(Pacote::class, 'aluno_pacote')->withPivot('descricao_pagamento');
    }

    public function isActive()
    {
        return $this->dias_restantes > 0;
    }

    public function decrementDaysRemaining()
    {
        if($this->dias_restantes > 0 && $this->matricula_ativa == 'ativa') {
            $this->dias_restantes--;
            $this->save();
        }
        
    }
}

