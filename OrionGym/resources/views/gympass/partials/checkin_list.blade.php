@forelse($checkins as $checkin)
    <tr>
        <td>{{ $checkin->id }}</td>
        <td>{{ $checkin->gympass_id }}</td>
        <td>
            @if($checkin->user)
                {{ $checkin->user->name }}
            @else
                <span class="badge badge-warning">Não identificado</span>
            @endif
        </td>
        <td>
            @if($checkin->user)
                {{ $checkin->user->card_number }}
            @else
                -
            @endif
        </td>
        <td>
            @if($checkin->status == 'approved')
                <span class="badge badge-success">Aprovado</span>
            @elseif($checkin->status == 'pending')
                <span class="badge badge-warning">Pendente</span>
            @else
                <span class="badge badge-danger">Rejeitado</span>
            @endif
        </td>
        <td>{{ $checkin->created_at->format('d/m/Y H:i:s') }}</td>
        <td>
            <button type="button" class="btn btn-sm btn-info" onclick="openModal('{{ $checkin->id }}')">
                <i class="fas fa-eye"></i>
            </button>

            <!-- Modal Content (Hidden) -->
            <div id="modal-content-{{ $checkin->id }}" style="display:none;">
                <pre>{{ json_encode($checkin->response_data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</pre>
            </div>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="7" class="text-center">Nenhum check-in registrado.</td>
    </tr>
@endforelse
