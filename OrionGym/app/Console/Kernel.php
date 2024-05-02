<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        Commands\CreateUser::class, // Adicione o nome completo do comando aqui
    ];

    // app\Console\Kernel.php

    protected function schedule(Schedule $schedule)
    {
        $schedule->command('app:update-package-days-remaining')->daily();
    }


    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
