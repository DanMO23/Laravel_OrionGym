@extends('layouts.impr-layout')

@section('content')
<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesquisa de Ficha de Treino</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        /* Custom CSS for Neumorphism and Dark Mode */
        body {
            background-color: #F7FAFC;
            color: #4A5568;
            transition: background-color 0.3s, color 0.3s;
            margin: 0;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        .neumorphic-card {
            background-color: #FFFFFF;
            border-radius: 1rem;
            padding: 2rem;
            box-shadow: 6px 6px 12px #c5c5c5,
                -6px -6px 12px #ffffff;
            transition: box-shadow 0.3s;
        }

        .neumorphic-card:hover {
            box-shadow: 3px 3px 6px #c5c5c5,
                -3px -3px 6px #ffffff;
        }

        .form-control {
            border-radius: 0.75rem;
            padding: 1rem;
            border: none;
            box-shadow: inset 2px 2px 5px #c5c5c5,
                inset -2px -2px 5px #ffffff;
            background-color: #F7FAFC;
            color: #4A5568;
            transition: box-shadow 0.3s;
        }

        .form-control:focus {
            outline: none;
            box-shadow: inset 3px 3px 6px #c5c5c5,
                inset -3px -3px 6px #ffffff;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1rem;
        }

        .table th,
        .table td {
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid #e2e8f0;
        }

        .table thead th {
            background-color: #edf2f7;
            color: #4A5568;
            font-weight: 600;
        }

        .btn {
            border-radius: 0.5rem;
            padding: 0.75rem 1.25rem;
            text-decoration: none;
            color: white;
            transition: transform 0.2s;
        }

        .btn:hover {
            transform: scale(1.05);
        }

        .btn-info {
            background-color: #3182ce;
        }

        .btn-success {
            background-color: #38a169;
        }

        /* Dark Mode Styles */
        body.dark-mode {
            background-color: #1A202C;
            color: #CBD5E0;
        }

        .dark-mode .neumorphic-card {
            background-color: #2D3748;
            box-shadow: 6px 6px 12px #1A202C,
                -6px -6px 12px #3D485E;
        }

        .dark-mode .neumorphic-card:hover {
            box-shadow: 3px 3px 6px #1A202C,
                -3px -3px 6px #3D485E;
        }

        .dark-mode .form-control {
            background-color: #2D3748;
            color: #CBD5E0;
            box-shadow: inset 2px 2px 5px #1A202C,
                inset -2px -2px 5px #3D485E;
        }

        .dark-mode .form-control:focus {
            box-shadow: inset 3px 3px 6px #1A202C,
                inset -3px -3px 6px #3D485E;
        }

        .dark-mode .table thead th {
            background-color: #2D3748;
            color: #CBD5E0;
        }

        .dark-mode .table td {
            border-bottom: 1px solid #4A5568;
        }

        /* Dark Mode Toggle Button */
        .dark-mode-toggle {
            position: fixed;
            top: 2rem;
            right: 2rem;
            background-color: #4A5568;
            color: #F7FAFC;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            z-index: 1000;
        }

        .dark-mode-toggle:hover {
            background-color: #2D3748;
            color: #CBD5E0;
        }

        .dark-mode .dark-mode-toggle {
            background-color: #CBD5E0;
            color: #2D3748;
        }

        .dark-mode .dark-mode-toggle:hover {
            background-color: #F7FAFC;
            color: #4A5568;
        }

        /* Responsive Styles */
        @media (max-width: 768px) {
            .container {
                padding: 1rem;
            }

            .neumorphic-card {
                border-radius: 0.75rem;
                padding: 1rem;
                box-shadow: none;
            }

            .form-control {
                border-radius: 0.5rem;
                padding: 0.75rem;
                font-size: 0.875rem;
            }

            .table th,
            .table td {
                padding: 0.75rem;
                font-size: 0.875rem;
            }

            .btn {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
            }
        }

        /* Additional Mobile Styles */
        @media (max-width: 576px) {
            .table th,
            .table td {
                padding: 0.5rem;
                font-size: 0.75rem;
            }

            .btn {
                padding: 0.5rem 0.75rem;
                font-size: 0.75rem;
            }

            .table thead {
                display: none;
            }

            .table tr {
                display: block;
                margin-bottom: 0.75rem;
            }

            .table td {
                display: block;
                text-align: right;
                padding-left: 50%;
                position: relative;
            }

            .table td:before {
                content: attr(data-label);
                position: absolute;
                left: 0;
                width: 50%;
                padding-left: 0.75rem;
                font-weight: bold;
                text-align: left;
            }
        }
    </style>
</head>

<body class="bg-gray-100">

    <button id="darkModeToggle" class="dark-mode-toggle">
        <i class="fas fa-moon"></i>
    </button>

    <div class="container mt-5">
        <div class="neumorphic-card">
            <h2 class="text-center mb-4 text-2xl font-semibold">🔍 Pesquise Sua Ficha de Treino</h2>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <input type="text" id="search" class="form-control form-control-lg text-center"
                        placeholder="Digite seu nome..." onkeyup="buscarFicha()">
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="neumorphic-card">
                <table class="table table-striped text-center">
                    <thead>
                        <tr>
                            <th>Nome do Aluno</th>
                            <th>Ficha</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody id="resultados">
                        <!-- Resultados aparecerão aqui -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const darkModeToggle = document.getElementById('darkModeToggle');
        const body = document.body;

        darkModeToggle.addEventListener('click', () => {
            body.classList.toggle('dark-mode');
        });

        function buscarFicha() {
            let nome = document.getElementById('search').value;
            fetch(`/pesquisaFicha/buscar?nome=${nome}`)
                .then(response => response.json())
                .then(data => {
                    let tabela = document.getElementById('resultados');
                    tabela.innerHTML = "";
                    data.forEach(ficha => {
                        tabela.innerHTML += `
                            <tr>
                                <td data-label="Nome do Aluno">${ficha.nome_aluno}</td>
                                <td data-label="Ficha">${ficha.nome_ficha}</td>
                                <td data-label="Ações">
                                    <a href="/pesquisaFicha/${ficha.id}" class="btn btn-info">
                                        <i class="fas fa-eye"></i> Ver Treinos
                                    </a>
                                </td>
                            </tr>`;
                    });
                });
        }
    </script>
</body>

</html>
@endsection