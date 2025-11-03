<?php

namespace App\Http\Controllers;

use App\Events\NovaCompra;
use Illuminate\Http\Request;
use App\Models\Aluno;
use App\Models\Pacote;
use App\Models\AlunoPacote;
use App\Events\CompraAtualizada;
use App\Events\CompraExcluida;
use App\Models\AlunosVencidos;

class CompraController extends Controller
{
    public function create()
    {
        $alunos = Aluno::orderBy('nome', 'asc')->get();
        $pacotes = Pacote::all();

        return view('compra.create', compact('alunos', 'pacotes'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'aluno' => 'required|exists:alunos,id',
            'pacote' => 'required|exists:pacotes,id',
            'valor_pacote' => 'required|numeric|min:0',
            'descricao_pagamento' => 'required|string',
            'adicionar_dias_extras' => 'nullable|in:0,1',
            'quantidade_dias_extras' => 'nullable|required_if:adicionar_dias_extras,1|integer|min:1|max:365',
            'valor_dias_extras' => 'nullable|required_if:adicionar_dias_extras,1|numeric|min:0'
        ]);

        $aluno = Aluno::findOrFail($request->aluno);
        $pacote = Pacote::findOrFail($request->pacote);

        // Verificar se é para adicionar dias extras
        $diasExtras = 0;
        $valorTotal = $request->valor_pacote;
        $descricaoCompleta = $request->descricao_pagamento;

        if ($request->adicionar_dias_extras == '1') {
            $diasExtras = $request->quantidade_dias_extras ?? 0;
            $valorDiasExtras = $request->valor_dias_extras ?? 0;
            $valorTotal += $valorDiasExtras;

            if ($diasExtras > 0) {
                $descricaoCompleta .= " | Dias extras: {$diasExtras} dia(s) por R$ " . number_format($valorDiasExtras, 2, ',', '.');
            }
        }

        // Calcular dias totais do pacote
        $diasTotais = $pacote->validade + $diasExtras;

        // Criar registro da compra
        $alunoPacote = AlunoPacote::create([
            'aluno_id' => $aluno->id,
            'pacote_id' => $pacote->id,
            'descricao_pagamento' => $descricaoCompleta,
            'valor_pacote' => $valorTotal,
        ]);

        // Atualizar dias restantes do aluno
        $aluno->dias_restantes += $diasTotais;

        if ($aluno->dias_restantes > 0) {
            $aluno->matricula_ativa = 'ativa';
        }

        $aluno->save();

        // Remover aluno da lista de vencidos se estiver lá
        $alunoVencido = AlunosVencidos::where('aluno_id', $request->aluno)->first();
        if ($alunoVencido) {
            $alunoVencido->delete();
        }

        // Disparar evento de nova compra
        event(new NovaCompra($alunoPacote));

        return redirect()->route('compra.historico')->with('success', 'Compra realizada com sucesso!');
    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $compras = AlunoPacote::with('aluno', 'pacote')
            ->when($search, function ($query, $search) {
                return $query->whereHas('aluno', function ($query) use ($search) {
                    $query->where('nome', 'like', "%{$search}%")
                          ->orWhere('numero_matricula', 'like', "%{$search}%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('compra.historico', compact('compras'));
    }

    public function historico()
    {
        $compras = AlunoPacote::orderBy('created_at', 'desc')->get(); // Recupera todas as compras do banco de dados
        return view('compras.historico', compact('compras'));
    }

    public function edit($id)
    {
        $compra = AlunoPacote::with('aluno')->findOrFail($id);
        $pacotes = Pacote::all(); // Carregar todos os pacotes
        return view('compra.edit', compact('compra', 'pacotes'));
    }
    public function update(Request $request, $id)
{
    $alunoPacote = AlunoPacote::findOrFail($id);
    $pacoteAntigoId = $alunoPacote->pacote_id;

    // Verificar se o campo para editar o valor do pacote foi marcado
    if ($request->has('editar_valor')){
        // Se sim, usar o valor preenchido pelo usuário
        $alunoPacote->valor_pacote = $request->input('valor_pacote');
    } else {
        // Caso contrário, verificar se foi selecionado um novo pacote
        if ($request->has('pacote')) {
            $pacoteSelecionado = Pacote::find($request->input('pacote'));
            if ($pacoteSelecionado) {
                $alunoPacote->valor_pacote = $pacoteSelecionado->valor;
            }
        }
    }

    // Atualizar outros campos se necessário
    $alunoPacote->pacote_id = $request->input('pacote');
    
    $alunoPacote->descricao_pagamento = $request->input('descricao_pagamento');
    $alunoPacote->save();

    event(new CompraAtualizada($alunoPacote, $pacoteAntigoId));

    return redirect()->route('compra.historico')->with('success', 'AlunoPacote atualizado com sucesso.');
}




    public function destroy($id)
    {
        // Recuperar a compra a ser excluída
        $compra = AlunoPacote::findOrFail($id);
        $aluno = Aluno::find($compra->aluno_id);
        
        // Disparar o evento de exclusão da compra
        event(new CompraExcluida($compra));
        
        // Excluir a compra
        $compra->delete();
       

        return redirect()->route('compra.historico')->with('success', 'Compra deletado com sucesso.');
    }
}
