<?php

namespace App\Listeners;

use App\Events\NovaCompra;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\AlunosVencidos;

class AtualizarDiasRestantes 
{
    public function __construct()
    {
        //
    }

    public function handle(NovaCompra $event)
    {
        $alunoPacote = $event->alunoPacote;
        $aluno = $alunoPacote->aluno;

        // Verifica se existe um pacote associado antes de adicionar os dias
        if ($alunoPacote->pacote) {
            // Adicione os dias da validade do pacote aos dias restantes do plano do aluno
            $aluno->dias_restantes += $alunoPacote->pacote->validade;
            $aluno->save();
        }

        // Remove o aluno da lista de vencidos se ele estiver lá
        $alunoVencido = AlunosVencidos::where('aluno_id', $aluno->id)->first();
        if ($alunoVencido) {
            $alunoVencido->delete();
        }
    }
}
