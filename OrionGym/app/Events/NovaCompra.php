<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\AlunoPacote;


class NovaCompra
{
    use Dispatchable, SerializesModels;

    public $alunoPacote;

    public function __construct(AlunoPacote $alunoPacote)
    {
        $this->alunoPacote = $alunoPacote;
    }
    
}
