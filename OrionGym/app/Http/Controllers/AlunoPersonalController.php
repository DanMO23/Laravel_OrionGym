<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AlunoPersonal;
use App\Models\Professor;
use App\Models\Aluno;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AlunoPersonalController extends Controller
{
    public function index(Request $request)
    {
        $query = AlunoPersonal::with(['professor', 'aluno']);

        // Filtrar por professor
        if ($request->filled('professor_id')) {
            $query->where('professor_id', $request->professor_id);
        }

        // Filtrar por status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filtrar por status de pagamento
        if ($request->filled('status_pagamento')) {
            $query->where('status_pagamento', $request->status_pagamento);
        }

        // Busca por nome ou CPF
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nome_completo', 'like', '%' . $request->search . '%')
                  ->orWhere('cpf', 'like', '%' . $request->search . '%');
            });
        }

        $alunosPersonal = $query->orderBy('data_vencimento', 'asc')->paginate(15);
        
        // Atualizar status de pagamento de todos
        foreach ($alunosPersonal as $aluno) {
            $aluno->atualizarStatusPagamento();
        }
        
        $professores = Professor::whereIn('tipo', ['personal', 'ambos'])->get();

        return view('alunos-personal.index', compact('alunosPersonal', 'professores'));
    }

    public function create()
    {
        $professores = Professor::whereIn('tipo', ['personal', 'ambos'])->get();
        $alunos = Aluno::where('matricula_ativa', 'ativa')->get();
        
        return view('alunos-personal.create', compact('professores', 'alunos'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'professor_id' => 'required|exists:professores,id',
                'tipo_aluno' => 'required|in:matriculado,externo',
                'nome_completo' => 'required_if:tipo_aluno,externo|string|max:255',
                'cpf' => 'nullable|string|max:14',
                'aluno_id' => 'required_if:tipo_aluno,matriculado|nullable|exists:alunos,id',
                'dia_vencimento' => 'required|integer|min:1|max:28',
                'valor_mensalidade' => 'nullable|numeric|min:0',
                'observacoes' => 'nullable|string'
            ]);

            // Se for aluno matriculado, pegar dados do aluno
            if ($validated['tipo_aluno'] === 'matriculado' && $request->filled('aluno_id')) {
                $aluno = Aluno::find($validated['aluno_id']);
                if ($aluno) {
                    $validated['nome_completo'] = $aluno->nome;
                    $validated['cpf'] = $aluno->cpf ?? '';
                    $validated['telefone'] = $aluno->telefone ?? '';
                    $validated['email'] = $aluno->email ?? '';
                }
            }

            // Calcular data de vencimento baseado no dia escolhido
            $diaVencimento = $validated['dia_vencimento'];
            $hoje = Carbon::now();
            
            // Criar data de vencimento corretamente
            if ($hoje->day > $diaVencimento) {
                // Se já passou o dia neste mês, vence no próximo mês
                $validated['data_vencimento'] = Carbon::create(
                    $hoje->year,
                    $hoje->month,
                    1
                )->addMonth()->addDays($diaVencimento - 1);
            } else {
                // Se ainda não passou, vence neste mês
                $validated['data_vencimento'] = Carbon::create(
                    $hoje->year,
                    $hoje->month,
                    $diaVencimento
                );
            }

            // Definir valores padrão
            $validated['status'] = 'ativo';
            $validated['status_pagamento'] = 'pendente';

            // Log para debug
            Log::info('Dados validados para criar aluno personal:', $validated);

            // Criar o aluno personal
            $alunoPersonal = AlunoPersonal::create($validated);

            return redirect()->route('alunos-personal.index')
                ->with('success', 'Aluno de personal cadastrado com sucesso!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Erro ao criar aluno personal: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return redirect()->back()
                ->with('error', 'Erro ao cadastrar aluno: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        // Carregar com os relacionamentos
        $alunoPersonal = AlunoPersonal::with(['professor', 'aluno'])->findOrFail($id);
        
        return view('alunos-personal.show', compact('alunoPersonal'));
    }

    public function edit(AlunoPersonal $alunoPersonal)
    {
        $professores = Professor::whereIn('tipo', ['personal', 'ambos'])->get();
        $alunos = Aluno::where('matricula_ativa', 'ativa')->get();
        
        return view('alunos-personal.edit', compact('alunoPersonal', 'professores', 'alunos'));
    }

    public function update(Request $request, AlunoPersonal $alunoPersonal)
    {
        $validated = $request->validate([
            'professor_id' => 'required|exists:professores,id',
            'data_vencimento' => 'required|date',
            'valor_mensalidade' => 'nullable|numeric|min:0',
            'status' => 'required|in:ativo,inativo',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'observacoes' => 'nullable|string'
        ]);

        $alunoPersonal->update($validated);

        return redirect()->route('alunos-personal.index')
            ->with('success', 'Aluno de personal atualizado com sucesso!');
    }

    public function destroy(AlunoPersonal $alunoPersonal)
    {
        $alunoPersonal->delete();

        return redirect()->route('alunos-personal.index')
            ->with('success', 'Aluno de personal removido com sucesso!');
    }

    public function registrarPagamento($id)
    {
        $alunoPersonal = AlunoPersonal::findOrFail($id);
        $alunoPersonal->registrarPagamento();

        return redirect()->back()
            ->with('success', 'Pagamento registrado com sucesso!');
    }

    public function painelPagamentos(Request $request)
    {
        $query = AlunoPersonal::with('professor');

        // Filtros
        if ($request->filled('professor_id')) {
            $query->where('professor_id', $request->professor_id);
        }

        if ($request->filled('status_pagamento')) {
            $query->where('status_pagamento', $request->status_pagamento);
        }

        if ($request->filled('mes')) {
            $mes = $request->mes;
            $query->whereMonth('data_vencimento', $mes);
        }

        $alunos = $query->orderBy('data_vencimento', 'asc')->paginate(20);
        
        // Atualizar status
        foreach ($alunos as $aluno) {
            $aluno->atualizarStatusPagamento();
        }

        $professores = Professor::whereIn('tipo', ['personal', 'ambos'])->get();

        // Estatísticas
        $totalAlunos = AlunoPersonal::count();
        $pagosEsseMes = AlunoPersonal::where('status_pagamento', 'pago')
            ->whereMonth('ultimo_pagamento', Carbon::now()->month)
            ->count();
        $atrasados = AlunoPersonal::where('status_pagamento', 'atrasado')->count();
        $pendentes = AlunoPersonal::where('status_pagamento', 'pendente')->count();
        
        $totalRecebido = AlunoPersonal::where('status_pagamento', 'pago')
            ->whereMonth('ultimo_pagamento', Carbon::now()->month)
            ->sum('valor_mensalidade');

        return view('alunos-personal.painel-pagamentos', compact(
            'alunos', 
            'professores', 
            'totalAlunos', 
            'pagosEsseMes', 
            'atrasados', 
            'pendentes',
            'totalRecebido'
        ));
    }
}
