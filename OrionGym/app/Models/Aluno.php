<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class Aluno extends Model
{
    protected $fillable = ['nome', 'email', 'telefone', 'data_nascimento', 'cpf', 'sexo', 'endereco', 'dias_restantes', 'numero_matricula'];

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
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Obter o último número de matrícula
            $lastMatricula = DB::table('alunos')->max('numero_matricula');

            // Definir o novo número de matrícula
            $model->numero_matricula = $lastMatricula ? $lastMatricula + 1 : 2222;
        });
    }
}

