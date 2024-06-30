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

    public function handlePackageDaysRemaining(){
        $aluno = $this;
        

        if ($aluno->dias_restantes == 0 && $aluno->matricula_ativa == 'ativa') {
            // Mover aluno para a tabela de alunos vencidos
            AlunosVencidos::create([
                'aluno_id' => $aluno->id,
                'nome' => $aluno->nome,
                'email' => $aluno->email,
                'telefone' => $aluno->telefone,
                'sexo' => $aluno->sexo,
                'numero_matricula' => $aluno->numero_matricula,
                'matricula_ativa' => $aluno->matricula_ativa,
            ]);
            $aluno->matricula_ativa = 'inativa';
            $aluno->save();

            // Opcional: Remover o aluno da tabela original, se necessário
            // $aluno->delete();
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

