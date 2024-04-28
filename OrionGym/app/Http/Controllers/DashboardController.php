<?php

namespace App\Http\Controllers;
use App\Models\Funcionario;
use Illuminate\Http\Request;
use App\Models\Aluno;

class DashboardController extends Controller
{
    public function index()
    {
        // Total de membros
        $totalMembros = Aluno::count();

        // Valor financeiro da academia (soma dos planos de todos os alunos)
        $valorFinanceiro = Aluno::with('pacotes')->get()->sum(function ($aluno) {
            return $aluno->pacotes->sum('valor');
        });

        // Número de funcionários (você precisa ter um modelo para os funcionários)
        $totalFuncionarios = Funcionario::count();

        // Dados para o gráfico de evolução (por exemplo, inscrições por mês)
        $dadosGrafico = [
            'Janeiro' => 100,
            'Fevereiro' => 120,
            'Março' => 150,
            // Adicione mais meses conforme necessário
        ];

        return view('dashboard', compact('totalMembros', 'valorFinanceiro', 'totalFuncionarios', 'dadosGrafico'));
    }
}
