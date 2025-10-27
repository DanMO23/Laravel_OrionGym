<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\AlunosVencidos;
use App\Models\AlunosResgate;
use App\Models\AlunoPacote;
use App\Events\NovaCompra;
use Illuminate\Support\Facades\DB;

class AlunoController extends Controller
{
    public function index()
    {
        $search = request('search');
        $perPage = request('per_page', 10); // Padrão: 10 itens por página
        $sortBy = request('sort_by', 'numero_matricula'); // Coluna de ordenação padrão
        $sortOrder = request('sort_order', 'asc'); // Ordem padrão: ascendente

        $query = Aluno::query();

        if ($search) {
            $query->where('nome', 'LIKE', "%{$search}%")
                ->orWhere('cpf', 'LIKE', "%{$search}%")
                ->orWhere('numero_matricula', 'LIKE', "%{$search}%");
        }

        // Aplicar ordenação
        $query->orderBy($sortBy, $sortOrder);

        // Aplicar paginação
        $alunos = $query->paginate($perPage)->appends([
            'search' => $search,
            'per_page' => $perPage,
            'sort_by' => $sortBy,
            'sort_order' => $sortOrder
        ]);

        return view('alunos.index', [
            'alunos' => $alunos, 
            'search' => $search,
            'perPage' => $perPage,
            'sortBy' => $sortBy,
            'sortOrder' => $sortOrder
        ]);
    }

    public function create()
    {
        return view('alunos.create');
    }

    public function store(Request $request)
    {
        $data = $request->all();
        if (!$request->filled('email')) {
            $data['email'] = '';
        }
        // Validar os dados do formulário
        $validatedData = $request->validate([
            'nome' => 'required|string|max:255',
            'email' => 'nullable|email|unique:alunos,email', // email agora pode ser nullable
            'telefone' => 'required|string|max:20',
            'data_nascimento' => 'required|date',
            'cpf' => 'required|string|max:14|unique:alunos,cpf',
            'sexo' => 'required|in:M,F',
            'endereco' => 'required|string|max:255',
        ], [
            'nome.required' => 'O campo nome é obrigatório.',
            'email.email' => 'Por favor, forneça um endereço de email válido.',
            'email.unique' => 'Este email já está em uso.',
            'telefone.required' => 'O campo telefone é obrigatório.',
            'data_nascimento.required' => 'O campo data de nascimento é obrigatório.',
            'data_nascimento.date' => 'Por favor, forneça uma data de nascimento válida.',
            'cpf.required' => 'O campo CPF é obrigatório.',
            'cpf.max' => 'O CPF não pode ter mais de 14 caracteres.',
            'cpf.unique' => 'Este CPF já está em uso.',
            'sexo.required' => 'O campo sexo é obrigatório.',
            'sexo.in' => 'Por favor, selecione um valor válido para o campo sexo.',
            'endereco.required' => 'O campo endereço é obrigatório.',
            'endereco.max' => 'O endereço não pode ter mais de 255 caracteres.',
        ]);

        // Criar um novo aluno com os dados fornecidos
        Aluno::create($validatedData);

        // Redirecionar de volta para a página de listagem de alunos com sucesso
        return redirect()->route('alunos.index')->with('success', 'Aluno criado com sucesso!');
    }

    public function search(Request $request)
    {
        // Este método pode ser removido, pois a busca agora está no index
        return $this->index();
    }

    public function show(Aluno $aluno)
    {
        return view('alunos.show', compact('aluno'));
    }

    public function trancarMatricula(Aluno $aluno)
    {
        $aluno = Aluno::findOrFail($aluno->id);
        $aluno->matricula_ativa = 'trancado';
        $aluno->save();

        return redirect()->route('alunos.index')->with('success', 'Matrícula do aluno trancada com sucesso.');
    }


    public function destrancarMatricula($id)
    {
        $aluno = Aluno::findOrFail($id);
        $aluno->matricula_ativa = 'ativa';
        $aluno->save();

        return redirect()->route('alunos.index')->with('success', 'Matrícula do aluno destrancada com sucesso.');
    }

    public function edit(Aluno $aluno)
    {
        return view('alunos.edit', compact('aluno'));
    }

    public function update(Request $request, Aluno $aluno)
    {
        $aluno->update($request->all());
        return redirect()->route('alunos.index');
    }

    public function destroy(Aluno $aluno)
    {
        $aluno->delete();
        return redirect()->route('alunos.index');
    }

    public function showTransferForm(Aluno $aluno)
    {
        $outrosAlunos = Aluno::where('id', '!=', $aluno->id)->get();
        return view('alunos.transferir', compact('aluno', 'outrosAlunos'));
    }

    public function transferirDias(Request $request, Aluno $aluno)
    {
        $request->validate([
            'aluno_destino_id' => 'required|exists:alunos,id',
            'dias' => 'required|integer|min:1',
        ]);

        $diasParaTransferir = (int)$request->input('dias');
        $alunoDestino = Aluno::findOrFail($request->input('aluno_destino_id'));

        if ($diasParaTransferir > $aluno->dias_restantes) {
            return redirect()->back()->with('error', 'Não é possível transferir mais dias do que o aluno possui.');
        }

        // Transação para garantir a consistência dos dados
        DB::transaction(function () use ($aluno, $alunoDestino, $diasParaTransferir) {
            $aluno->dias_restantes -= $diasParaTransferir;
            $aluno->save();

            $alunoDestino->dias_restantes += $diasParaTransferir;

            if ($alunoDestino->dias_restantes > 0) {
                $alunoDestino->matricula_ativa = 'ativa';
            }

            $alunoDestino->save();

            // Registra a transferência para o aluno de origem
            $transferenciaOrigem = AlunoPacote::create([
                'aluno_id' => $aluno->id,
                'pacote_id' => null,
                'descricao_pagamento' => "Transferência de {$diasParaTransferir} dias para {$alunoDestino->nome}",
                'valor_pacote' => 0,
            ]);
            event(new NovaCompra($transferenciaOrigem));

            // Registra a transferência para o aluno de destino
            $transferenciaDestino = AlunoPacote::create([
                'aluno_id' => $alunoDestino->id,
                'pacote_id' => null,
                'descricao_pagamento' => "Recebimento de {$diasParaTransferir} dias de {$aluno->nome}",
                'valor_pacote' => 0,
            ]);
            event(new NovaCompra($transferenciaDestino));
        });

        return redirect()->route('alunos.show', $aluno->id)->with('success', 'Dias transferidos com sucesso!');
    }

    public function resgateIndex()
    {
        $alunosResgate = AlunosResgate::all();
        $alunosVencidos = AlunosVencidos::all();
        return view('alunos.resgate', compact('alunosResgate', 'alunosVencidos'));
    }

    public function resgatarAlunos(Request $request)
    {
        $matriculas = explode(',', $request->input('numero_matricula'));
        $matriculas = array_map('trim', $matriculas);

        $alunosVencidos = AlunosVencidos::whereIn('numero_matricula', $matriculas)->get();

        foreach ($alunosVencidos as $alunoVencido) {
            $alunoResgate = new AlunosResgate();
            $alunoResgate->nome = $alunoVencido->nome;
            $alunoResgate->telefone = $alunoVencido->telefone;
            $alunoResgate->numero_matricula = $alunoVencido->numero_matricula;
            $alunoResgate->save();

            // Remove o aluno da tabela de AlunosVencidos
            $alunoVencido->delete();
        }

        return redirect()->route('alunos.resgate')->with('success', 'Alunos resgatados com sucesso!');
    }

    public function removerResgate($id)
    {
        $alunoResgate = AlunosResgate::findOrFail($id);
        $alunoResgate->delete();

        return redirect()->route('alunos.resgate')->with('success', 'Aluno removido da lista de resgate.');
    }

    public function alunosVencidos()
    {
        $alunosVencidos = AlunosVencidos::all();
        //Retorna os alunos vencidos em ordem descrecente de data de criacao
        $alunosVencidos = AlunosVencidos::orderBy('created_at', 'desc')->get();
        return view('alunos.vencidos', compact('alunosVencidos'));
    }

    public function indexVencidos()
    {
        $alunosVencidos = AlunosVencidos::all();
        return view('alunos.vencidos', compact('alunosVencidos'));
    }

    public function bloquear($id)
    {
        $alunoVencido = AlunosVencidos::findOrFail($id);
        $aluno = Aluno::find($alunoVencido->aluno_id);
        if ($aluno) {
            $aluno->matricula_ativa = 'bloqueado';

            $aluno->save();
            $alunoVencido->matricula_ativa = 'bloqueado';
            $alunoVencido->save();
        }

        return redirect()->route('alunos.vencidos')->with('success', 'Status do aluno atualizado com sucesso.');
    }

}
