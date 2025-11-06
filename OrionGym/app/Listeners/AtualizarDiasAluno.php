<?php

namespace App\Listeners;

use App\Events\NovaCompra;
use App\Models\Aluno;
use App\Models\Pacote;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AtualizarDiasAluno
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NovaCompra $event): void
    {
        // REMOVER TODA A LÓGICA DE ATUALIZAÇÃO DE DIAS AQUI
        // Pois já está sendo feito no CompraController::store()
        
        // Este listener pode ser usado apenas para logs ou notificações
        // mas NÃO deve atualizar os dias do aluno
    }
}
