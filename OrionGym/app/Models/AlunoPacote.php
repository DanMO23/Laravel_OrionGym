<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlunoPacote extends Model
{
    protected $table = 'aluno_pacote';

    protected $fillable = [
        'aluno_id',
        'pacote_id',
        'descricao_pagamento'
    ];

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    public function pacote()
    {
        return $this->belongsTo(Pacote::class);
    }
}
