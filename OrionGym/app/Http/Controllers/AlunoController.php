<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aluno;

class AlunoController extends Controller
{
    public function index()
    {

        $search = request('search');

        if ($search) {
            $alunos = Aluno::where([
                ['nome', 'like', '%' . $search . '%']
            ])->get();
        } else {
            $alunos = Aluno::all();
        }

        return view('alunos.index', ['alunos' => $alunos, 'search' => $search]);
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
        $searchTerm = $request->input('search');

        // Buscar alunos no banco de dados com base no termo de busca
        $alunos = Aluno::where('nome', 'LIKE', "%{$searchTerm}%")
            ->orWhere('email', 'LIKE', "%{$searchTerm}%")
            ->orWhere('telefone', 'LIKE', "%{$searchTerm}%")
            ->orWhere('cpf', 'LIKE', "%{$searchTerm}%")
            ->orWhere('endereco', 'LIKE', "%{$searchTerm}%")
            ->get();

        // Retornar a view com os resultados da busca
        return view('alunos.index', ['alunos' => $alunos, 'searchTerm' => $searchTerm]);
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
}
