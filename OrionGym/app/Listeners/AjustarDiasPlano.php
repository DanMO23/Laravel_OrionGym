<?php
namespace App\Listeners;

use App\Events\CompraAtualizada;
use App\Models\Pacote;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AjustarDiasPlano 
{
    public function __construct()
    {
        //
    }

    public function handle(CompraAtualizada $event)
    {
        $alunoPacote = $event->alunoPacote;
        
        $aluno = $alunoPacote->aluno;

        // Subtrair os dias do pacote antigo
        $pacoteAntigo = Pacote::find($event->pacoteAntigoId);
        if ($pacoteAntigo) {
            $aluno->dias_restantes -= $pacoteAntigo->validade;
        }
        
        // Adicionar os dias do novo pacote
        $aluno->dias_restantes += $alunoPacote->pacote->validade;
        $aluno->save();
    }
}
