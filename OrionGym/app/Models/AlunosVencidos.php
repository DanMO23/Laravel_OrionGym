<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlunosVencidos extends Model
{
    use HasFactory;

    protected $fillable = ['aluno_id', 'nome', 'email', 'telefone', 'sexo', 'numero_matricula', 'matricula_ativa'];

    /**
     * Relacionamento com o aluno original.
     */
    public function aluno()
    {
        return $this->belongsTo(Aluno::class, 'aluno_id');
    }

    /**
     * Retorna a última compra de pacote do aluno.
     */
    public function ultimaCompra()
    {
        return $this->hasOne(AlunoPacote::class, 'aluno_id', 'aluno_id')->latest();
    }
}
