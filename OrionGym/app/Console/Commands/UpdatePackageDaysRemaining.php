<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AlunoPacote;
use App\Models\Aluno;
use Illuminate\Support\Facades\Log; 


class UpdatePackageDaysRemaining extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-package-days-remaining';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Buscar todos os registros de AlunoPacote
        $alunosAnalisados = Aluno::all();

        // Iterar sobre cada registro e decrementar os dias restantes
        foreach ($alunosAnalisados as $alunoPacote) {
            // Verificar se o pacote está ativo
            $alunoPacote->decrementDaysRemaining();

            if ($alunoPacote->dias_restantes == 0 && $alunoPacote->matricula_ativa == 'ativa') {
                $alunoPacote->handlePackageDaysRemaining();
               
            }

        }
        Log::info('A tarefa diária foi executada à meia-noite');
        $this->info('Dias dos pacotes decrementados com sucesso!');
    }
}
