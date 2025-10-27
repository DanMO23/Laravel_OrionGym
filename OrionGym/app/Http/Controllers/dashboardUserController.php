<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Aluno;
use App\Models\AlunoPacote;
use App\Models\Compra;
use App\Models\Pacote;
use Illuminate\Http\Request;
use App\Models\CompraProduto;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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

        // === NOVAS ESTATÍSTICAS DE ALUNOS ===
        
        // Distribuição por Gênero
        $distribuicaoGenero = [
            'masculino' => Aluno::where('sexo', 'M')->count(),
            'feminino' => Aluno::where('sexo', 'F')->count()
        ];

        // Distribuição por Faixa Etária
        $hoje = Carbon::now();
        $distribuicaoIdade = [
            '18-25' => Aluno::whereBetween('data_nascimento', [
                $hoje->copy()->subYears(25)->format('Y-m-d'),
                $hoje->copy()->subYears(18)->format('Y-m-d')
            ])->count(),
            '26-35' => Aluno::whereBetween('data_nascimento', [
                $hoje->copy()->subYears(35)->format('Y-m-d'),
                $hoje->copy()->subYears(26)->format('Y-m-d')
            ])->count(),
            '36-45' => Aluno::whereBetween('data_nascimento', [
                $hoje->copy()->subYears(45)->format('Y-m-d'),
                $hoje->copy()->subYears(36)->format('Y-m-d')
            ])->count(),
            '46-60' => Aluno::whereBetween('data_nascimento', [
                $hoje->copy()->subYears(60)->format('Y-m-d'),
                $hoje->copy()->subYears(46)->format('Y-m-d')
            ])->count(),
            '60+' => Aluno::where('data_nascimento', '<', $hoje->copy()->subYears(60)->format('Y-m-d'))->count()
        ];

        // Distribuição de Dias Restantes
        $distribuicaoDias = [
            '0' => Aluno::where('dias_restantes', 0)->count(),
            '1-5' => Aluno::whereBetween('dias_restantes', [1, 5])->count(),
            '6-15' => Aluno::whereBetween('dias_restantes', [6, 15])->count(),
            '16-30' => Aluno::whereBetween('dias_restantes', [16, 30])->count(),
            '30+' => Aluno::where('dias_restantes', '>', 30)->count()
        ];

        // Novos Alunos por Mês (últimos 12 meses)
        $novosAlunosMes = [];
        $mesesNomes = ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'];
        
        for ($i = 11; $i >= 0; $i--) {
            $data = Carbon::now()->subMonths($i);
            $mes = $mesesNomes[$data->month - 1];
            $count = Aluno::whereYear('created_at', $data->year)
                          ->whereMonth('created_at', $data->month)
                          ->count();
            $novosAlunosMes[$mes] = $count;
        }

        // Taxa de Renovação/Retenção (alunos que compraram mais de um pacote)
        $alunosComMultiplaCompra = AlunoPacote::select('aluno_id')
            ->groupBy('aluno_id')
            ->havingRaw('COUNT(*) > 1')
            ->count();
        
        $taxaRetencao = $totalMembros > 0 ? round(($alunosComMultiplaCompra / $totalMembros) * 100, 1) : 0;

        // Pacotes Mais Populares
        $pacotesMaisVendidos = AlunoPacote::select('pacote_id', DB::raw('COUNT(*) as total'))
            ->whereNotNull('pacote_id')
            ->groupBy('pacote_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get()
            ->map(function($item) {
                $pacote = Pacote::find($item->pacote_id);
                return [
                    'nome' => $pacote ? $pacote->nome_pacote : 'Desconhecido',
                    'total' => $item->total
                ];
            });

        // Status de Matrícula Detalhado
        $statusMatricula = [
            'ativa' => Aluno::where('matricula_ativa', 'ativa')->count(),
            'inativa' => Aluno::where('matricula_ativa', 'inativa')->count(),
            'trancado' => Aluno::where('matricula_ativa', 'trancado')->count(),
            'bloqueado' => Aluno::where('matricula_ativa', 'bloqueado')->count()
        ];

        // Média de Dias Restantes
        $mediaDiasRestantes = round(Aluno::avg('dias_restantes'), 1);

        // === NOVAS ESTATÍSTICAS DE DESEMPENHO ===
        
        // Taxa de Crescimento Mensal (últimos 6 meses)
        $crescimentoMensal = [];
        for ($i = 5; $i >= 0; $i--) {
            $data = Carbon::now()->subMonths($i);
            $mes = $mesesNomes[$data->month - 1];
            $count = Aluno::where('created_at', '<=', $data->endOfMonth())->count();
            $crescimentoMensal[$mes] = $count;
        }

        // Renovações vs Novos Alunos (últimos 6 meses)
        $renovacoesVsNovos = [];
        for ($i = 5; $i >= 0; $i--) {
            $data = Carbon::now()->subMonths($i);
            $mes = $mesesNomes[$data->month - 1];
            
            $novosAlunos = Aluno::whereYear('created_at', $data->year)
                               ->whereMonth('created_at', $data->month)
                               ->count();
            
            $renovacoes = AlunoPacote::whereYear('created_at', $data->year)
                                    ->whereMonth('created_at', $data->month)
                                    ->whereHas('aluno', function($query) use ($data) {
                                        $query->where('created_at', '<', $data->startOfMonth());
                                    })
                                    ->count();
            
            $renovacoesVsNovos[$mes] = [
                'novos' => $novosAlunos,
                'renovacoes' => $renovacoes
            ];
        }

        // Alunos Por Status ao Longo do Tempo (últimos 6 meses)
        $statusTemporal = [];
        for ($i = 5; $i >= 0; $i--) {
            $data = Carbon::now()->subMonths($i);
            $mes = $mesesNomes[$data->month - 1];
            
            // Simular snapshot do status naquele mês
            $statusTemporal[$mes] = [
                'ativos' => $membrosAtivos,
                'bloqueados' => $membrosBloqueados,
                'inativos' => $totalMembros - $membrosAtivos - $membrosBloqueados
            ];
        }

        // Média de Compras por Aluno
        $mediaComprasPorAluno = $totalMembros > 0 ? round(AlunoPacote::count() / $totalMembros, 2) : 0;

        // Churn Rate (alunos que saíram nos últimos 3 meses)
        $alunosInativos3Meses = Aluno::where('matricula_ativa', 'inativa')
                                     ->where('updated_at', '>=', Carbon::now()->subMonths(3))
                                     ->count();
        $churnRate = $totalMembros > 0 ? round(($alunosInativos3Meses / $totalMembros) * 100, 1) : 0;

        // Ticket Médio
        $ticketMedio = AlunoPacote::whereNotNull('valor_pacote')->avg('valor_pacote');
        $ticketMedio = $ticketMedio ? round($ticketMedio, 2) : 0;

        // === FATURAMENTO (ADMIN APENAS) ===
        
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
                $mesCompra = $dataCompra->month;
                
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

        $mesAtual = date('m');
        $anoAtual = date('Y');

        $valorVendasMesAtual = CompraProduto::whereYear('created_at', $anoAtual)
                                             ->whereMonth('created_at', $mesAtual)
                                             ->sum('valor_total');

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
            'faturamentoMensal',
            'distribuicaoGenero',
            'distribuicaoIdade',
            'distribuicaoDias',
            'novosAlunosMes',
            'taxaRetencao',
            'pacotesMaisVendidos',
            'statusMatricula',
            'mediaDiasRestantes',
            'crescimentoMensal',
            'renovacoesVsNovos',
            'statusTemporal',
            'mediaComprasPorAluno',
            'churnRate',
            'ticketMedio'
        ));
    }
}
