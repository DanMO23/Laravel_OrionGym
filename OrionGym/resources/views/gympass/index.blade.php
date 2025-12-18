@extends('layouts.user-layout')

@section('content')
<div class="container-fluid">
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1 class="m-0 text-dark">Integração Gympass</h1>
        </div>
    </div>

    <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-header p-0 border-bottom-0">
            <ul class="nav nav-tabs" id="gympass-tab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-link-cadastro" href="javascript:void(0)" onclick="openTab('cadastro')">Cadastro de Usuário</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-link-usuarios" href="javascript:void(0)" onclick="openTab('usuarios')">Usuários Cadastrados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-link-historico" href="javascript:void(0)" onclick="openTab('historico')">Histórico de Check-ins</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="gympass-tabContent">
                
                <!-- Aba Cadastro -->
                <div class="tab-pane fade show active" id="tab-content-cadastro">
                    <form action="{{ route('gympass.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="name">Nome Completo</label>
                                    <input type="text" class="form-control" id="name" name="name" required placeholder="Digite o nome do usuário">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="gympass_id">Gympass ID (Número do Usuário)</label>
                                    <input type="text" class="form-control" id="gympass_id" name="gympass_id" required placeholder="Digite o ID do Gympass">
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save mr-1"></i> Cadastrar Usuário</button>
                    </form>
                </div>

                <!-- Aba Usuários Cadastrados -->
                <div class="tab-pane fade" id="tab-content-usuarios">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <button type="button" class="btn btn-secondary" onclick="openTab('cadastro')">
                                <i class="fas fa-plus-circle mr-1"></i> Adicionar usuário
                            </button>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                                </div>
                                <input type="text" class="form-control" id="userSearchInput" onkeyup="filterUsers()" placeholder="Pesquisar por nome, cartão ou ID...">
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap table-bordered">
                            <thead class="thead-light">
                                <tr>
                                    <th>Cartão</th>
                                    <th class="text-center">Biometria</th>
                                    <th class="text-center">Dispensa verificação</th>
                                    <th class="text-center">Horários</th>
                                    <th class="text-center">Opções</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($gympassUsers as $user)
                                    <tr>
                                        <td>{{ $user->card_number }}</td>
                                        <td class="text-center">
                                            <i class="fas fa-fingerprint text-primary" style="font-size: 1.2rem;"></i>
                                        </td>
                                        <td class="text-center">
                                            <!-- Exemplo de checkbox disabled apenas para visualização -->
                                            <input type="checkbox" disabled>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-success">Lib</span>
                                        </td>
                                        <td class="text-center">
                                            <button class="btn btn-sm btn-outline-primary" onclick="openEditModal('{{ $user->id }}', '{{ $user->name }}', '{{ $user->card_number }}')">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <button class="btn btn-sm btn-outline-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">Nenhum usuário Gympass cadastrado.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Aba Histórico -->
                <div class="tab-pane fade" id="tab-content-historico">
                    <div class="d-flex justify-content-end mb-2">
                        <button type="button" class="btn btn-outline-primary btn-sm" onclick="refreshCheckins(this)">
                            <i class="fas fa-sync-alt mr-1"></i> Atualizar Lista
                        </button>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover text-nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Gympass ID</th>
                                    <th>Usuário</th>
                                    <th>Cartão (Sistema)</th>
                                    <th>Status</th>
                                    <th>Data/Hora</th>
                                    <th>Detalhes</th>
                                </tr>
                            </thead>
                            <tbody id="checkin-list-body">
                                @include('gympass.partials.checkin_list')
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $checkins->links() }}
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card -->
    </div>
</div>

<!-- Modal Genérico para Detalhes -->
<div class="modal fade" id="genericModal" tabindex="-1" role="dialog" aria-labelledby="genericModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="genericModalLabel">Detalhes do Check-in</h5>
                <button type="button" class="close" onclick="closeModal('genericModal')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="genericModalBody">
                <!-- Conteúdo será injetado aqui -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" onclick="closeModal('genericModal')">Fechar</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Edição de Usuário -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="editUserModalLabel">Editar Informações de Usuário</h5>
                <button type="button" class="close" onclick="closeModal('editUserModal')" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <!-- Linha Cartão -->
                    <div class="form-group row align-items-center">
                        <label for="edit_card_number" class="col-sm-2 col-form-label">Cartão</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control" id="edit_card_number" readonly>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-light border mr-1">Cadastrar</button>
                            <button type="button" class="btn btn-light border"><i class="fas fa-id-card mr-1"></i> Cadastrar via leitor</button>
                        </div>
                    </div>

                    <!-- Linha Biometrias -->
                    <div class="form-group row align-items-center">
                        <label for="biometrics_count" class="col-sm-2 col-form-label">Biometrias</label>
                        <div class="col-sm-4">
                            <div class="input-group">
                                <input type="text" class="form-control" id="biometrics_count" value="0" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-secondary" type="button"><i class="fas fa-trash"></i></button>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <button type="button" class="btn btn-light border"><i class="fas fa-fingerprint mr-1"></i> Cadastrar via leitor</button>
                        </div>
                    </div>

                    <!-- Linha Dispensa -->
                    <div class="form-group row">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-10">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="waiver_verification">
                                <label class="form-check-label" for="waiver_verification">
                                    Dispensar verificação biométrica
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Linha Horários -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Horários</label>
                        <div class="col-sm-4">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="schedule_type" id="schedule_liberado" value="liberado" checked>
                                <label class="form-check-label" for="schedule_liberado">Liberado</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="schedule_type" id="schedule_bloqueado" value="bloqueado">
                                <label class="form-check-label" for="schedule_bloqueado">Bloqueado</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="schedule_type" id="schedule_horario" value="horario">
                                <label class="form-check-label" for="schedule_horario">Conforme horário</label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="d-flex">
                                <select multiple class="form-control mr-2" style="height: 100px; background-color: #e9ecef;">
                                    <!-- Horários listados aqui -->
                                </select>
                                <div class="d-flex flex-column">
                                    <button type="button" class="btn btn-light border mb-1"><i class="fas fa-plus"></i></button>
                                    <button type="button" class="btn btn-light border"><i class="fas fa-minus"></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" onclick="closeModal('editUserModal')">Fechar</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function openTab(tabName) {
        // Remover classe active de todos os links
        document.getElementById('tab-link-cadastro').classList.remove('active');
        document.getElementById('tab-link-usuarios').classList.remove('active');
        document.getElementById('tab-link-historico').classList.remove('active');
        
        // Esconder todos os conteúdos
        document.getElementById('tab-content-cadastro').classList.remove('show', 'active');
        document.getElementById('tab-content-usuarios').classList.remove('show', 'active');
        document.getElementById('tab-content-historico').classList.remove('show', 'active');
        
        // Ativar o link clicado
        document.getElementById('tab-link-' + tabName).classList.add('active');
        
        // Mostrar o conteúdo correspondente
        document.getElementById('tab-content-' + tabName).classList.add('show', 'active');
    }

    // Função genérica para abrir modais manualmente
    function showModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.style.display = 'block';
        modal.style.backgroundColor = 'rgba(0,0,0,0.5)';
        setTimeout(function() {
            modal.classList.add('show');
        }, 10);
        document.body.classList.add('modal-open');
    }

    // Função genérica para fechar modais manualmente
    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        modal.classList.remove('show');
        setTimeout(function() {
            modal.style.display = 'none';
        }, 150);
        document.body.classList.remove('modal-open');
    }

    function openModal(checkinId) {
        var content = document.getElementById('modal-content-' + checkinId).innerHTML;
        document.getElementById('genericModalBody').innerHTML = content;
        showModal('genericModal');
    }

    function openEditModal(userId, userName, cardNumber) {
        document.getElementById('edit_card_number').value = cardNumber;
        // Aqui você pode carregar mais dados do usuário via AJAX se necessário
        showModal('editUserModal');
    }
    
    function refreshCheckins(btn) {
        var originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Atualizando...';
        btn.disabled = true;

        $.ajax({
            url: "{{ route('gympass.index') }}",
            type: 'GET',
            success: function(response) {
                $('#checkin-list-body').html(response);
            },
            error: function() {
                alert('Erro ao atualizar a lista.');
            },
            complete: function() {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        });
    }

    function filterUsers() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("userSearchInput");
        filter = input.value.toUpperCase();
        table = document.querySelector("#tab-content-usuarios table");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) { // Começa em 1 para pular o cabeçalho
            // Verifica várias colunas (Cartão, e talvez nome se estivesse na tabela, mas a tabela só tem cartão. O user pediu dados iguais da imagem que tem cartão. Mas a lista de usuários tem nome?)
            // A tabela atual tem: Cartão, Biometria, Dispensa, Horários, Opções.
            // O objeto $user tem nome. Vou adicionar o nome como data-attribute ou coluna oculta ou visível se fizer sentido.
            // A imagem mostrava "Cartão" como primeira coluna.
            // Vou filtrar pelo texto da primeira coluna (Cartão).
            
            td = tr[i].getElementsByTagName("td")[0]; // Coluna Cartão
            if (td) {
                txtValue = td.textContent || td.innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }       
        }
    }

    // Fechar modal ao clicar fora dele
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            closeModal(event.target.id);
        }
    }
</script>
@endpush
