<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CatracaService;

class CatracaController extends Controller
{
    protected $catracaService;

    public function __construct(CatracaService $catracaService)
    {
        $this->catracaService = $catracaService;
    }
    public function index()
    {
        return view('catraca.index');
    }

    public function abrirCatraca(Request $request)
    {
        $comando = "ABRIR";  // Ajuste conforme a documentação da API da catraca
        $response = $this->catracaService->enviarComando($comando);

        return response()->json(['response' => $response]);
    }

    public function consultarLogs(Request $request)
    {
        $comando = "CONSULTAR_LOGS";  // Ajuste conforme a documentação da API da catraca
        $response = $this->catracaService->enviarComando($comando);

        return response()->json(['logs' => $response]);
    }
}


