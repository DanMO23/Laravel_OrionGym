<?php

namespace App\Http\Controllers;

use App\Models\FichaTreino;
use App\Models\Treino;
use App\Models\Exercicio;
use App\Models\Aluno;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;  // Changed this line
use Carbon\Carbon;

class FichaTreinoController extends Controller
{
    public function create()
    {
        $alunos = Aluno::all();
        return view('fichas.create', compact('alunos'));
    }

    public function store(Request $request)
    {
        try {
            // Debug dos dados recebidos antes da validação
            Log::info('Dados recebidos no request:', $request->all());

            // Validação dos dados
            $validator = Validator::make($request->all(), [
                'nome_aluno' => 'required|string|max:255',
                'nome_ficha' => 'required|string|max:255',
                'exercicios' => 'required|array',
                'exercicios.A' => 'required|array',
                'exercicios.B' => 'required|array',
                'exercicios.A.*.nome_exercicio' => 'required|string|max:255',
                'exercicios.A.*.series' => 'required|integer|min:1',
                'exercicios.A.*.repeticoes_tempo' => 'required|string',
                'exercicios.A.*.descanso' => 'required|string',
                'exercicios.B.*.nome_exercicio' => 'required|string|max:255',
                'exercicios.B.*.series' => 'required|integer|min:1',
                'exercicios.B.*.repeticoes_tempo' => 'required|string',
                'exercicios.B.*.descanso' => 'required|string',
            ]);

            if ($validator->fails()) {
                Log::error('Erros de validação:', $validator->errors()->toArray());
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput()
                    ->with('error', 'Erro na validação dos dados: ' . $validator->errors()->first());
            }

            // Debug dos dados recebidos
            Log::info('Dados recebidos:', $request->all());

            // Criação da ficha
            $ficha = FichaTreino::create([
                'nome_aluno' => $request->nome_aluno,
                'nome_ficha' => $request->nome_ficha,
            ]);

            if (!$ficha) {
                throw new \Exception('Erro ao criar a ficha de treino');
            }

            Log::info('Ficha criada:', ['id' => $ficha->id]);

            $treinosPadrao = ['A', 'B'];
            if ($request->has('treinoC')) {
                $treinosPadrao[] = 'C';
            }
            if ($request->has('treinoD')) {
                $treinosPadrao[] = 'D';
            }

            foreach ($treinosPadrao as $nomeTreino) {
                $treino = Treino::create([
                    'ficha_treino_id' => $ficha->id,
                    'nome_treino' => $nomeTreino,
                ]);

                Log::info("Treino {$nomeTreino} criado:", ['treino_id' => $treino->id]);

                if (isset($request->exercicios[$nomeTreino])) {
                    foreach ($request->exercicios[$nomeTreino] as $exercicioData) {
                        try {
                            $exercicio = Exercicio::create([
                                'treino_id' => $treino->id,
                                'nome_exercicio' => $exercicioData['nome_exercicio'],
                                'series' => $exercicioData['series'],
                                'repeticoes_tempo' => $exercicioData['repeticoes_tempo'],
                                'descanso' => $exercicioData['descanso'],
                            ]);

                            Log::info("Exercício criado para treino {$nomeTreino}:", [
                                'exercicio_id' => $exercicio->id,
                                'nome' => $exercicioData['nome_exercicio']
                            ]);
                        } catch (\Exception $e) {
                            Log::error("Erro ao criar exercício:", [
                                'treino' => $nomeTreino,
                                'erro' => $e->getMessage(),
                                'dados' => $exercicioData
                            ]);
                            throw new \Exception('Erro ao criar exercício: ' . $e->getMessage());
                        }
                    }
                } else {
                    Log::warning("Nenhum exercício encontrado para o treino {$nomeTreino}");
                }
            }

            return redirect()->route('fichas.index')
                ->with('success', 'Ficha de treino criada com sucesso.');

        } catch (\Exception $e) {
            Log::error('Erro ao criar ficha de treino:', [
                'erro' => $e->getMessage(),
                'linha' => $e->getLine(),
                'arquivo' => $e->getFile()
            ]);

            return redirect()->back()
                ->withInput()
                ->with('error', 'Erro ao criar ficha de treino: ' . $e->getMessage());
        }
    }
    public function imprimir($id)
    {
        $ficha = FichaTreino::findOrFail($id);
        $treinos = Treino::where('ficha_treino_id', $id)->get();

        // Determinar o próximo treino a ser impresso
        $ultimoTreinoImpresso = Session::get('ultimo_treino_impresso_' . $id, null);
        $proximoTreino = null;

        if ($ultimoTreinoImpresso) {
            $indiceUltimoTreino = $treinos->search(function ($treino) use ($ultimoTreinoImpresso) {
                return $treino->id == $ultimoTreinoImpresso->id;
            });

            if ($indiceUltimoTreino !== false && $indiceUltimoTreino < count($treinos) - 1) {
                $proximoTreino = $treinos[$indiceUltimoTreino + 1];
            }
        }

        // Se não houver próximo treino, ou for o primeiro acesso, pega o primeiro treino
        if (!$proximoTreino) {
            $proximoTreino = $treinos->first();
        }

        // Se o treino estiver vazio, pegar o proximo
        if ($proximoTreino && $proximoTreino->exercicios->count() == 0) {
            $indiceTreino = $treinos->search(function ($treino) use ($proximoTreino) {
                return $treino->id == $proximoTreino->id;
            });
            if ($indiceTreino !== false && $indiceTreino < count($treinos) - 1) {
                $proximoTreino = $treinos[$indiceTreino + 1];
            } else {
                $proximoTreino = $treinos->first();
            }
        }

        // Atualizar a sessão com o treino impresso
        Session::put('ultimo_treino_impresso_' . $id, $proximoTreino);

        // Gerar o PDF
        $data = [
            'ficha' => $ficha,
            'treino' => $proximoTreino,
            'data_hora_impressao' => Carbon::now()->format('d/m/Y H:i:s'),
        ];

        $pdf = PDF::loadView('fichas.pdf', $data);

        // Configurar o tamanho do papel
        $pdf->setPaper([0, 0, 226.772, 841.89], 'portrait'); // 80mm

        // Retornar o PDF para o navegador
        return $pdf->stream('ficha_treino.pdf');
    }

    public function index()
    {
        $fichas = FichaTreino::all();
        return view('fichas.index', compact('fichas'));

    }
    public function show($id)
    {
        $ficha = FichaTreino::findOrFail($id);
        $treinos = Treino::where('ficha_treino_id', $id)->get();
        return view('fichas.show', compact('ficha', 'treinos'));
    }

}