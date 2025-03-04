<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ficha de Treino</title>
    <style>
        body {
            font-family: monospace;
            font-size: 9px;
            line-height: 1.2;
        }
        .container {
            width: 100%;
            max-width: 80mm;
            margin: 0 auto;
            padding: 5px;
        }
        .header {
            text-align: center;
            margin-bottom: 5px;
        }
        .header-title {
            font-size: 10px;
            font-weight: bold;
        }
        .header-info {
            font-size: 8px;
        }
        .section {
            margin-bottom: 8px;
        }
        .section-title {
            font-size: 9px;
            font-weight: bold;
            margin-bottom: 3px;
            border-bottom: 1px dashed #000;
            padding-bottom: 2px;
        }
        .exercise-table {
            width: 100%;
            border-collapse: collapse;
        }
        .exercise-table th, .exercise-table td {
            border: none;
            padding: 2px;
            text-align: center;
        }
        .exercise-table th {
            font-weight: bold;
        }
        .exercise-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 2px;
        }
        .exercise-name {
            width: 50%;
            text-align: left;
        }
        .exercise-sets, .exercise-reps, .exercise-rest {
            width: 16.66%;
            text-align: center;
        }
        .footer {
            text-align: center;
            font-size: 8px;
            margin-top: 10px;
            border-top: 1px dashed #000;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-title">ACADEMIA ORION</div>
            <div class="header-info">FICHA DE TREINO</div>
            <div class="header-info">DATA: {{ \Carbon\Carbon::parse($ficha->created_at)->format('d/m/Y') }}</div>
        </div>

        <div class="section">
            <div class="header-info">NOME: {{ $ficha->nome_aluno }}</div>
            <div class="header-info">OBJETIVO: {{ $ficha->nome_ficha }}</div>
          
            <div class="header-info">REAVALIACAO:</div>
            <div class="header-info">OBS:</div>
            <div class="header-info">"Acredite em você, você é capaz de tudo!"</div>
           
        </div>

        @if ($treino)
            <div class="section">
                <div class="section-title">TREINO {{$treino->nome_treino}}</div>
                <table class="exercise-table">
                    <thead>
                        <tr>
                            <th>Exercício</th>
                            <th>S.</th>
                            <th>ReP/Temp</th>
                            <th>D.</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($treino->exercicios as $exercicio)
                            <tr>
                                <td style="text-align: left;">{{ $loop->iteration }}-{{ $exercicio->nome_exercicio }}</td>
                                <td>{{ $exercicio->series }}</td>
                                <td>{{ $exercicio->repeticoes_tempo }}</td>
                                <td>{{ $exercicio->descanso }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="section">
                <p>Nenhum treino cadastrado para esta ficha.</p>
            </div>
        @endif

        <div class="footer">
            EMITIDO EM: {{ $data_hora_impressao }}
        </div>
    </div>
</body>
</html>