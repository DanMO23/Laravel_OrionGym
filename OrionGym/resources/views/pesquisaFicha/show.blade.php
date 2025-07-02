<!DOCTYPE html>
 <html lang="pt-BR">
 

 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ficha de Treino</title>
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
 

  /* Custom Styles */
  .ficha-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  }
 

  .ficha-title {
  font-size: 2rem;
  font-weight: bold;
  color: #3182ce;
  }
 

  .aluno-info {
  font-size: 1.25rem;
  color: #4A5568;
  }
 

  .treino-card {
  background-color: #FFFFFF;
  border-radius: 1rem;
  padding: 2rem;
  box-shadow: 6px 6px 12px #c5c5c5,
  -6px -6px 12px #ffffff;
  margin-bottom: 2rem;
  transition: box-shadow 0.3s;
  }
 

  .treino-card:hover {
  box-shadow: 3px 3px 6px #c5c5c5,
  -3px -3px 6px #ffffff;
  }
 

  .treino-title {
  font-size: 1.5rem;
  font-weight: bold;
  color: #3182ce;
  margin-bottom: 1rem;
  }
 

  .no-exercicios {
  color: #718096;
  font-style: italic;
  }
 

  .action-buttons {
  display: flex;
  justify-content: flex-end;
  margin-top: 2rem;
  }

    .btn-secondary {
    background-color: #2c5282; /* Azul */
    color: #ffffff; /* Texto branco */
}

.btn-secondary:hover {
    background-color: #2c5282; /* Azul mais escuro no hover */
}

.mr-2 {
    margin-right: 0.5rem;
}
  </style>
 </head>
 

 <body class="bg-gray-100">
  
  <button id="darkModeToggle" class="dark-mode-toggle">
  <i class="fas fa-moon"></i>
  </button>
 

  <div class="container mt-5">
  <div class="neumorphic-card">
  <div class="ficha-header">
  <h1 class="ficha-title">Ficha de Treino - {{ $ficha->nome_ficha }}</h1>
  <p class="aluno-info">Aluno: {{ $ficha->nome_aluno }}</p>
  </div>
 

  <!-- Exibição dos Treinos -->
  @foreach ($treinos as $treino)
  <div class="treino-card">
  <h2 class="treino-title">Treino {{ $treino->nome_treino }}</h2>
  @if ($treino->exercicios->count() > 0)
  <table class="table table-striped text-center">
  <thead>
  <tr>
  <th>Exercício</th>
  <th>Séries</th>
  <th>Repetições/Tempo</th>
  <th>Descanso</th>
  </tr>
  </thead>
  <tbody>
  @foreach ($treino->exercicios as $exercicio)
  <tr>
  <td>{{ $exercicio->nome_exercicio }}</td>
  <td>{{ $exercicio->series }}</td>
  <td>{{ $exercicio->repeticoes_tempo }}</td>
  <td>{{ $exercicio->descanso }}</td>
  </tr>
  @endforeach
  </tbody>
  </table>
  @else
  <p class="no-exercicios">Nenhum exercício cadastrado para este treino.</p>
  @endif
  </div>
  @endforeach
 

  <!-- Botões de Ação -->
  <div class="action-buttons">
    <a href="{{ route('pesquisaFicha.index') }}" class="btn btn-secondary mr-2">
      <i class="fas fa-arrow-left"></i> Voltar
    </a>
    <a href="{{ route('fichas.imprimir', $ficha->id) }}" class="btn btn-success" target="_blank">
      <i class="fas fa-print"></i> Imprimir Ficha
    </a>
  </div>
  </div>
  </div>
 

  <script>
  const darkModeToggle = document.getElementById('darkModeToggle');
  const body = document.body;
 

  darkModeToggle.addEventListener('click', () => {
  body.classList.toggle('dark-mode');
  });
  </script>
 </body>
 

 </html>