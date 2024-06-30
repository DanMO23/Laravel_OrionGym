<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AlunoPacote;
use App\Models\Pacote;

class UpdateCompraValores extends Command
{
    protected $signature = 'compra:update-valores';

    protected $description = 'Atualiza os valores das compras existentes com os valores corretos dos pacotes';

    public function handle()
    {
        // Carregar todos os pacotes
        $pacotes = Pacote::all();

        // Iterar sobre todas as compras existentes
        $compras = AlunoPacote::all();

        foreach ($compras as $compra) {
            // Encontrar o pacote correspondente pelo ID
            $pacote = $pacotes->where('id', $compra->pacote_id)->first();

            if ($pacote) {
                // Atualizar o valor_pacote da compra com o valor do pacote correspondente
                $compra->valor_pacote = $pacote->valor;
                $compra->save();
            }
        }

        $this->info('Valores das compras atualizados com sucesso!');
    }
}
