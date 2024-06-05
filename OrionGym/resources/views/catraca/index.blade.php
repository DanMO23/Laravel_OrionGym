@extends('layouts.user-layout')

@section('title', 'Catraca')

@section('content')
<button id="abrirCatraca">Abrir Catracaaa</button>
    <p id="response"></p>

    <script>
        $(document).ready(function() {
            $('#abrirCatraca').click(function() {
                $.ajax({
                    url: '/catraca/abrir',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#response').text(response.response);
                    },
                    error: function(xhr) {
                        $('#response').text('Erro ao abrir a catraca: ' + xhr.responseJSON.response);
                    }
                });
            });
        });
    </script>
@endsection
