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
        $compras = AlunoPacote::whereYear('created_at', date('Y'))->get();
       
        foreach ($compras as $compra) {
            $pacote = Pacote::find($compra->pacote_id);

            if ($pacote) {
                $diasValidade = $pacote->validade;
                $valorPacote = $pacote->valor;

                if ($diasValidade > 30) {
                    $numMeses = intdiv($diasValidade, 30);
                    $valorPacote *= $numMeses;
                }

                $dataCompra = Carbon::parse($compra->created_at);
                $mesCompra = $dataCompra->month; // Mês da compra
                
                // Adicionar o valor do pacote ao mês da compra
                switch($mesCompra){
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

        //para o valor dos produtos, separe o valor do mes atual, considerando as compras que foram executadas no mes
        $mesAtual = date('m');
        $anoAtual = date('Y');

        $valorVendasMesAtual = CompraProduto::whereYear('created_at', $anoAtual)
                                             ->whereMonth('created_at', $mesAtual)
                                             ->sum('valor_total');

        //aggora, some o valorVendasMesAtual ao faturamentoMensal, no mes correto
        switch($mesAtual){
            case '01': $faturamentoMensal['January'] += $valorVendasMesAtual; break;
            case '02': $faturamentoMensal['February'] += $valorVendasMesAtual; break;
            case '03': $faturamentoMensal['March'] += $valorVendasMesAtual; break;
            case '04': $faturamentoMensal['April'] += $valorVendasMesAtual; break;
            case '05': $faturamentoMensal['May'] += $valorVendasMesAtual; break;
            case '06': $faturamentoMensal['June'] += $valorVendasMesAtual; break;
            case '07': $faturamentoMensal['July'] += $valorVendasMesAtual; break;
            case '08': $faturamentoMensal['August'] += $valorVendasMesAtual; break;
            case '09': $faturamentoMensal['September'] += $valorVendasMesAtual; break;
            case '10': $faturamentoMensal['October'] += $valorVendasMesAtual; break;
            case '11': $faturamentoMensal['November'] += $valorVendasMesAtual; break;
            case '12': $faturamentoMensal['December'] += $valorVendasMesAtual; break;
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
