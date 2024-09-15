<?php

namespace App\Http\Controllers;

use App\Models\Funcionario;
use App\Models\Aluno;
use App\Models\AlunoPacote;
use App\Models\Compra; // Certifique-se de incluir o modelo correto
use App\Models\Pacote;
use Illuminate\Http\Request;
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
        // Dados para o gráfico de evolução
        $dadosGrafico = [
            'Janeiro' => 100,
            'Fevereiro' => 120,
            'Março' => 150,
            // Adicione mais meses conforme necessário
        ];

        // Recuperar todas as compras
        $compras = AlunoPacote::all();

        // Inicializar variáveis para total mensal e total financeiro
        $totalMensal = 0;
        $totalQuadrimestral = 0;
        $totalSemestral = 0;
        $totalAnual = 0;

        // Data atual e início do mês
        $dataAtual = Carbon::now();
        $inicioDoMes = $dataAtual->copy()->startOfMonth();
        $fimDoMes = $dataAtual->copy()->endOfMonth();

        foreach ($compras as $compra) {
            $pacote = Pacote::find($compra->pacote_id);
            
            if ($pacote) {
                $nomePacote = $pacote->nome_pacote;
                $valorPacote = $pacote->valor;
                $dataCompra = Carbon::parse($compra->created_at);

                // Verificar o tipo de pacote e calcular o valor
                if (strpos($nomePacote, 'Mensal') !== false || strpos($nomePacote, 'Horário Especial') !== false || $nomePacote === 'Avaliação Física') {
                    $diasValidos = 30;
                } elseif (strpos($nomePacote, 'Quadrimestral') !== false) {
                    $diasValidos = 120;
                } elseif (strpos($nomePacote, 'Semestral') !== false) {
                    $diasValidos = 180;
                } elseif (strpos($nomePacote, 'Anual') !== false) {
                    $diasValidos = 365;
                } else {
                    continue; // Se não corresponder a nenhum tipo, pular
                }

                // Calcular a data final do pacote
                $dataFinal = $dataCompra->copy()->addDays($diasValidos);

                // Verificar se o pacote está dentro do período atual
                if ($dataFinal->greaterThanOrEqualTo($inicioDoMes) && $dataCompra->lessThanOrEqualTo($fimDoMes)) {
                    $totalMensal += $valorPacote;
                }
                
                // Acumular valores para outros períodos, se necessário
                if (strpos($nomePacote, 'Quadrimestral') !== false) {
                    $totalQuadrimestral += $valorPacote;
                } elseif (strpos($nomePacote, 'Semestral') !== false) {
                    $totalSemestral += $valorPacote;
                } elseif (strpos($nomePacote, 'Anual') !== false) {
                    $totalAnual += $valorPacote;
                }
            }
        }

        // Preparar dados para a view
        return view('dashboardUser', compact('valorFinanceiro','membrosAtivos', 'membrosBloqueados', 'totalMembros', 'totalMensal', 'totalQuadrimestral', 'totalSemestral', 'totalAnual', 'totalFuncionarios', 'dadosGrafico'));
    }
}
