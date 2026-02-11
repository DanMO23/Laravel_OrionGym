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

        // Usar dias_totais se disponível (inclui dias extras), senão usar validade do pacote
        $diasAAdicionar = $alunoPacote->dias_totais ?? ($alunoPacote->pacote ? $alunoPacote->pacote->validade : 0);
        
        if ($diasAAdicionar > 0) {
            $aluno->dias_restantes += $diasAAdicionar;
            
            if ($aluno->dias_restantes > 0) {
                $aluno->matricula_ativa = 'ativa';
            }
            
            $aluno->save();
        }

        // Remove o aluno da lista de vencidos se ele estiver lá
        $alunoVencido = AlunosVencidos::where('aluno_id', $aluno->id)->first();
        if ($alunoVencido) {
            $alunoVencido->delete();
        }
    }
}
