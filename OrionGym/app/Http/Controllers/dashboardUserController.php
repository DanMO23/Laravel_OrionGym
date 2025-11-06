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

        // Novos alunos por mês (últimos 12 meses)
        $novosAlunosMes = [];
        for ($i = 11; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i)->format('M/Y');
            $novosAlunosMes[$mes] = Aluno::whereYear('created_at', Carbon::now()->subMonths($i)->year)
                                         ->whereMonth('created_at', Carbon::now()->subMonths($i)->month)
                                         ->count();
        }

        // Garantir que novosAlunosMes sempre seja um array
        if (empty($novosAlunosMes)) {
            $novosAlunosMes = ['Sem dados' => 0];
        }

        // Outras métricas necessárias para a dashboard
        $distribuicaoGenero = [
            'masculino' => Aluno::where('sexo', 'M')->count(),
            'feminino' => Aluno::where('sexo', 'F')->count()
        ];

        $distribuicaoIdade = [
            '18-25' => Aluno::whereBetween('data_nascimento', [Carbon::now()->subYears(25), Carbon::now()->subYears(18)])->count(),
            '26-35' => Aluno::whereBetween('data_nascimento', [Carbon::now()->subYears(35), Carbon::now()->subYears(26)])->count(),
            '36-50' => Aluno::whereBetween('data_nascimento', [Carbon::now()->subYears(50), Carbon::now()->subYears(36)])->count(),
            '50+' => Aluno::where('data_nascimento', '<', Carbon::now()->subYears(50))->count(),
        ];

        $distribuicaoDias = [
            '0 dias' => Aluno::where('dias_restantes', 0)->count(),
            '1-7 dias' => Aluno::whereBetween('dias_restantes', [1, 7])->count(),
            '8-15 dias' => Aluno::whereBetween('dias_restantes', [8, 15])->count(),
            '16-30 dias' => Aluno::whereBetween('dias_restantes', [16, 30])->count(),
            '30+ dias' => Aluno::where('dias_restantes', '>', 30)->count(),
        ];

        $pacotesMaisVendidos = Pacote::withCount('alunos')
            ->orderBy('alunos_count', 'desc')
            ->take(5)
            ->get()
            ->map(function($pacote) {
                return [
                    'nome' => $pacote->nome_pacote,
                    'total' => $pacote->alunos_count
                ];
            });

        $statusMatricula = [
            'ativa' => Aluno::where('matricula_ativa', 'ativa')->count(),
            'inativa' => Aluno::where('matricula_ativa', 'inativa')->count(),
            'trancado' => Aluno::where('matricula_ativa', 'trancado')->count(),
            'bloqueado' => Aluno::where('matricula_ativa', 'bloqueado')->count(),
        ];

        $taxaRetencao = $totalMembros > 0 
            ? round((Aluno::has('pacotes', '>=', 2)->count() / $totalMembros) * 100, 1) 
            : 0;

        $mediaDiasRestantes = $totalMembros > 0 
            ? round(Aluno::avg('dias_restantes'), 0) 
            : 0;

        $crescimentoMensal = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i)->format('M/Y');
            $crescimentoMensal[$mes] = Aluno::where('created_at', '<=', Carbon::now()->subMonths($i)->endOfMonth())->count();
        }

        $renovacoesVsNovos = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i)->format('M/Y');
            $renovacoesVsNovos[$mes] = [
                'novos' => Aluno::whereYear('created_at', Carbon::now()->subMonths($i)->year)
                               ->whereMonth('created_at', Carbon::now()->subMonths($i)->month)
                               ->count(),
                'renovacoes' => AlunoPacote::whereYear('created_at', Carbon::now()->subMonths($i)->year)
                                          ->whereMonth('created_at', Carbon::now()->subMonths($i)->month)
                                          ->whereHas('aluno', function($q) use ($i) {
                                              $q->where('created_at', '<', Carbon::now()->subMonths($i)->startOfMonth());
                                          })
                                          ->count()
            ];
        }

        $statusTemporal = [];
        for ($i = 5; $i >= 0; $i--) {
            $mes = Carbon::now()->subMonths($i)->format('M/Y');
            $statusTemporal[$mes] = [
                'ativos' => Aluno::where('matricula_ativa', 'ativa')
                                ->where('created_at', '<=', Carbon::now()->subMonths($i)->endOfMonth())
                                ->count(),
                'bloqueados' => Aluno::where('matricula_ativa', 'bloqueado')
                                    ->where('created_at', '<=', Carbon::now()->subMonths($i)->endOfMonth())
                                    ->count(),
                'inativos' => Aluno::where('matricula_ativa', 'inativa')
                                  ->where('created_at', '<=', Carbon::now()->subMonths($i)->endOfMonth())
                                  ->count(),
            ];
        }

        $ticketMedio = AlunoPacote::avg('valor_pacote') ?? 0;
        $mediaComprasPorAluno = $totalMembros > 0 
            ? round(AlunoPacote::count() / $totalMembros, 1) 
            : 0;

        $churnRate = $totalMembros > 0 
            ? round((Aluno::where('matricula_ativa', 'inativa')
                         ->where('updated_at', '>=', Carbon::now()->subMonths(3))
                         ->count() / $totalMembros) * 100, 1) 
            : 0;

        // Preparar dados para a view
        return view('dashboardUser', compact(
            'valorFinanceiro',
            'membrosAtivos',
            'membrosBloqueados',
            'totalMembros',
            'totalFuncionarios',
            'faturamentoMensal',
            'novosAlunosMes',
            'distribuicaoGenero',
            'distribuicaoIdade',
            'distribuicaoDias',
            'pacotesMaisVendidos',
            'statusMatricula',
            'taxaRetencao',
            'mediaDiasRestantes',
            'crescimentoMensal',
            'renovacoesVsNovos',
            'statusTemporal',
            'ticketMedio',
            'mediaComprasPorAluno',
            'churnRate'
        ));
    }
}
