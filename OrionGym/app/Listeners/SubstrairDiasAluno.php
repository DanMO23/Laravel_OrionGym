<?php

namespace App\Listeners;

use App\Events\CompraExcluida;
use App\Models\Aluno;
use App\Models\Pacote;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SubstrairDiasAluno
{
    /**
     * Handle the event.
     *
     * @param  \App\Events\CompraExcluida  $event
     * @return void
     */
    public function handle(CompraExcluida $event)
    {
        $compra = $event->compra;
        $aluno = Aluno::findOrFail($compra->aluno_id);
        $pacote = Pacote::find($compra->pacote_id);

        // Usar dias_totais se disponível (inclui dias extras), senão usar validade do pacote
        $diasASubtrair = $compra->dias_totais ?? ($pacote ? $pacote->validade : 0);
        
        // Subtrair os dias do plano do aluno
        $aluno->dias_restantes -= $diasASubtrair;
       
        // Garantir que dias_restantes não fique negativo
        if ($aluno->dias_restantes < 0) {
            $aluno->dias_restantes = 0;
        }

        if ($aluno->dias_restantes == 0 && $aluno->matricula_ativa == 'ativa') {
            $aluno->handlePackageDaysRemaining();
        }
        
        // Salvar a atualização
        $aluno->save();
    }
}
