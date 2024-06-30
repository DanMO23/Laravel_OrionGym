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
        $pacote = Pacote::findOrFail($compra->pacote_id);

        
        // Subtrair os dias do plano do aluno
        $aluno->dias_restantes -= $pacote->validade;
       
        if ($compra->dias_restantes == 0 && $compra->matricula_ativa == 'ativa') {
                $compra->handlePackageDaysRemaining();
                
               
            }
        
        // Salvar a atualização
        $aluno->save();
    }
}
