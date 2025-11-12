@extends('layouts.impr-layout')

@section('content')
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Ficha de Treino</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }

        .search-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .search-card {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .search-title {
            color: #667eea;
            font-size: 2rem;
            font-weight: bold;
            text-align: center;
            margin-bottom: 1.5rem;
        }

        .search-input {
            border-radius: 50px;
            padding: 1rem 2rem;
            border: 2px solid #e0e0e0;
            font-size: 1.1rem;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .search-input:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .ficha-card {
            transition: all 0.3s ease;
        }

        .hover-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            background: white;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .hover-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
        }

        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
            text-align: center;
        }

        .avatar-circle {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid rgba(255, 255, 255, 0.5);
            margin: 0 auto 1rem;
        }

        .card-body {
            background: #f8f9fa;
            padding: 1.5rem;
        }

        .btn-view {
            border-radius: 8px;
            font-weight: 500;
            padding: 0.75rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            color: white;
            transition: all 0.3s;
        }

        .btn-view:hover {
            transform: scale(1.05);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .no-results {
            text-align: center;
            padding: 3rem;
            color: white;
        }

        .no-results i {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .search-title {
                font-size: 1.5rem;
            }
            
            .search-input {
                font-size: 1rem;
                padding: 0.75rem 1.5rem;
            }
        }
    </style>
</head>

<body>
    <div class="search-container">
        <div class="search-card">
            <h2 class="search-title">
                <i class="fas fa-search"></i> Pesquise Sua Ficha de Treino
            </h2>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <input type="text" id="search" class="form-control search-input text-center"
                        placeholder="Digite seu nome..." onkeyup="buscarFicha()">
                </div>
            </div>
        </div>

        <div id="resultadosContainer">
            <div class="no-results">
                <i class="fas fa-clipboard-list"></i>
                <p class="lead">Digite seu nome para encontrar sua ficha de treino</p>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function buscarFicha() {
            let nome = document.getElementById('search').value;
            
            if (nome.length < 2) {
                document.getElementById('resultadosContainer').innerHTML = `
                    <div class="no-results">
                        <i class="fas fa-clipboard-list"></i>
                        <p class="lead">Digite pelo menos 2 caracteres para pesquisar</p>
                    </div>
                `;
                return;
            }

            fetch(`/pesquisaFicha/buscar?nome=${nome}`)
                .then(response => response.json())
                .then(data => {
                    let container = document.getElementById('resultadosContainer');
                    
                    if (data.length === 0) {
                        container.innerHTML = `
                            <div class="no-results">
                                <i class="fas fa-exclamation-circle"></i>
                                <p class="lead">Nenhuma ficha encontrada para "${nome}"</p>
                            </div>
                        `;
                        return;
                    }

                    let html = '<div class="row">';
                    data.forEach(ficha => {
                        html += `
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-4 ficha-card">
                                <div class="card hover-card h-100">
                                    <div class="card-header">
                                        <div class="avatar-circle">
                                            <i class="fas fa-user fa-2x"></i>
                                        </div>
                                        <h5 class="mb-0">${ficha.nome_aluno}</h5>
                                    </div>
                                    <div class="card-body d-flex flex-column">
                                        <div class="mb-3">
                                            <p class="text-muted mb-1"><i class="fas fa-bullseye"></i> Objetivo:</p>
                                            <p class="font-weight-bold">${ficha.nome_ficha}</p>
                                        </div>
                                        <div class="mt-auto">
                                            <a href="/pesquisaFicha/${ficha.id}" class="btn btn-view btn-block">
                                                <i class="fas fa-eye"></i> Ver Treinos
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                    html += '</div>';
                    container.innerHTML = html;
                });
        }
    </script>
</body>

</html>
@endsection