<?php

namespace App\Events;

use App\Models\AlunoPacote;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CompraExcluida
{
    use Dispatchable, SerializesModels;

    public $compra;

    /**
     * Create a new event instance.
     *
     * @param  \App\Models\AlunoPacote $compra
     * @return void
     */
    public function __construct(AlunoPacote $compra)
    {
        $this->compra = $compra;
    }
}
