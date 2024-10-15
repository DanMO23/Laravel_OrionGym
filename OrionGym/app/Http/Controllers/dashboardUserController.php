<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Aluno;
use App\Models\AlunoPacote;
use App\Models\Compra; // Certifique-se de incluir o modelo correto
use App\Models\Pacote;
use Illuminate\Http\Request;
use App\Models\CompraProduto;
use Carbon\Carbon;

class dashboardUserController extends Controller
{
    public function index()
    {
        // Total de membros
        $totalMembros = Aluno::count();
        $membrosAtivos = Aluno::where('matricula_ativa', 'ativa')->count();
        $membrosBloqueados = Aluno::where('matricula_ativa', 'bloqueado')->count();

        // Número de funcionários
        $totalFuncionarios = Funcionario::count();
        $valorFinanceiro = Aluno::with('pacotes')->get()->sum(function ($aluno) {
            return $aluno->pacotes->sum('valor');
        });

        // Vetores representando cada mês do ano
        $faturamentoMensal = [
            'January' => 0,
            'February' => 0,
            'March' => 0,
            'April' => 0,
            'May' => 0,
            'June' => 0,
            'July' => 0,
            'August' => 0,
            'September' => 0,
            'October' => 0,
            'November' => 0,
            'December' => 0,
        ];

        // Recuperar todas as compras
        $compras = AlunoPacote::all();
       



        foreach ($compras as $compra) {
            $pacote = Pacote::find($compra->pacote_id);

            if ($pacote) {
                $diasValidade = $pacote->validade;
                $valorPacote = $pacote->valor;
                $dataCompra = Carbon::parse($compra->created_at);
                $mesCompra = $dataCompra->month; // Mês da compra
                $numMeses = 0;

                // Determinar o número de meses com base nos dias de validade
                if ($diasValidade == 30) {
                    $numMeses = 1; // Mensal
                } elseif ($diasValidade == 120) {
                    $numMeses = 4; // Quadrimestral
                } elseif ($diasValidade == 180) {
                    $numMeses = 6; // Semestral
                } elseif ($diasValidade == 365) {
                    $numMeses = 12; // Anual
                } else {
                    continue; // Pula pacotes que não se encaixam
                }

                // Distribuir o valor pelos meses
                for ($i = 0; $i < $numMeses; $i++) {
                    // Calcula o mês para somar o valor
                    $mesAtual = ($mesCompra + $i - 1) % 12 + 1;

                    // Distribuir o faturamento pelos meses em inglês
                   
                    switch($mesAtual){
                        case 1: $faturamentoMensal['January'] += $valorPacote; break;
                        case 2: $faturamentoMensal['February'] += $valorPacote; break;
                        case 3: $faturamentoMensal['March'] += $valorPacote; break;
                        case 4: $faturamentoMensal['April'] += $valorPacote; break;
                        case 5: $faturamentoMensal['May'] += $valorPacote; break;
                        case 6: $faturamentoMensal['June'] += $valorPacote; break;
                        case 7: $faturamentoMensal['July'] += $valorPacote; break;
                        case 8: $faturamentoMensal['August'] += $valorPacote; break;
                        case 9: $faturamentoMensal['September'] += $valorPacote; break;
                        case 10: $faturamentoMensal['October'] += $valorPacote; break;
                        case 11: $faturamentoMensal['November'] += $valorPacote; break;
                        case 12: $faturamentoMensal['December'] += $valorPacote; break;
                    }
                }
            }
        }
        //para o valor dos produtos, separe o valor do mes atual, considerando as compras que foram executadas no mes
        $valorVendas = CompraProduto::all();

        $mesAtual = date('m');
        $valorVendasMesAtual = 0;
        //faça agora o valorVendas para o mes atual
        foreach ($valorVendas as $venda) {
            if ($venda->created_at->format('m') == $mesAtual) {
                $valorVendasMesAtual += $venda->valor_total;
                }
                }

        //aggora, some o valorVendasMesAtual ao faturamentoMensal, no mes correto
        switch($mesAtual){
            case 1: $faturamentoMensal['January'] += $valorVendasMesAtual;
            case 2: $faturamentoMensal['February'] += $valorVendasMesAtual;
            case 3: $faturamentoMensal['March'] += $valorVendasMesAtual;
            case 4: $faturamentoMensal['April'] += $valorVendasMesAtual;
            case  5: $faturamentoMensal['May'] += $valorVendasMesAtual;
            case 6: $faturamentoMensal['June'] += $valorVendasMesAtual;
            case 7: $faturamentoMensal['July'] += $valorVendasMesAtual;
            case 8: $faturamentoMensal['August'] += $valorVendasMesAtual;
            case  9: $faturamentoMensal['September'] += $valorVendasMesAtual;
            case 10: $faturamentoMensal['October'] += $valorVendasMesAtual;
            case 11: $faturamentoMensal['November'] += $valorVendasMesAtual;
            case 12: $faturamentoMensal['December'] += $valorVendasMesAtual;
            }
            
       

        // Preparar dados para a view
        return view('dashboardUser', compact(
            'valorFinanceiro',
            'membrosAtivos',
            'membrosBloqueados',
            'totalMembros',
            'totalFuncionarios',
            'faturamentoMensal'
        ));
    }
}
