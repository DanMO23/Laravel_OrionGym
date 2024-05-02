<?php

namespace App\Listeners;

use App\Events\NovaCompra;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

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

        // Adicione os dias da validade do pacote aos dias restantes do plano do aluno
        $aluno->dias_restantes += $alunoPacote->pacote->validade;
        $aluno->save();
    }
}
