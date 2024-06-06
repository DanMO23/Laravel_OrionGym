<?php

namespace App\Providers;

use App\Events\CompraAtualizada;
use App\Events\CompraDeletada;
use App\Events\CompraExcluida;
use App\Events\NovaCompra;
use App\Listeners\AjustarDiasPlano;
use App\Listeners\AtualizarDiasRestantes;
use App\Listeners\SubstrairDiasAluno;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use App\Listeners\SubstrairDiasPlano;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        NovaCompra::class => [
            AtualizarDiasRestantes::class,
        ],
        CompraAtualizada::class => [
            AjustarDiasPlano::class,
        ],
        CompraExcluida::class => [
            SubstrairDiasAluno::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
    
    
}
