<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Permission\Models\Role;

class CreateRoles extends Command
{
    /**
     * O nome e a assinatura do comando no console.
     *
     * @var string
     */
    protected $signature = 'create:roles';

    /**
     * A descrição do comando no console.
     *
     * @var string
     */
    protected $description = 'Cria as roles no sistema';

    /**
     * Cria uma nova instância do comando.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Executa o comando para criar as roles.
     *
     * @return mixed
     */
    public function handle()
    {
        // Criar as roles necessárias
       Role::create(['name' => 'admin', 'guard_name' => 'web']);
        Role::create(['name' => 'user', 'guard_name' => 'web']);

        // Exibir mensagem de sucesso
        $this->info('Roles criadas com sucesso!');
    }
}
