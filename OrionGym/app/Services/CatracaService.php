<?php 
namespace App\Services;

class CatracaService
{
    protected $host;
    protected $port;

    public function __construct()
    {
        $this->host = env('CATRACA_HOST');
        $this->port = env('CATRACA_PORT');
    }

    public function enviarComando($comando)
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false) {
            throw new \Exception("Não foi possível criar o socket: " . socket_strerror(socket_last_error()));
        }

        $result = socket_connect($socket, $this->host, $this->port);
        if ($result === false) {
            throw new \Exception("Não foi possível conectar ao socket: " . socket_strerror(socket_last_error($socket)));
        }

        socket_write($socket, $comando, strlen($comando));
        $response = socket_read($socket, 2048);
        socket_close($socket);

        return $response;
    }

    public function testarConexao()
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        if ($socket === false) {
            return false;
        }

        $result = @socket_connect($socket, $this->host, $this->port);
        if ($result === false) {
            socket_close($socket);
            return false;
        }

        socket_close($socket);
        return true;
    }
}
