<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlunoPacote extends Model
{
    protected $table = 'aluno_pacote';

    protected $fillable = [
        'aluno_id',
        'pacote_id',
        'descricao_pagamento',
        'valor_pacote'
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id');
    }

    public function pacote()
    {
        return $this->belongsTo(Pacote::class, 'pacote_id');
    }
}
