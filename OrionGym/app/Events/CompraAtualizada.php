<?php
namespace App\Events;

use App\Models\AlunoPacote;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CompraAtualizada
{
    use Dispatchable, SerializesModels;

    public $alunoPacote;
    public $pacoteAntigoId;

    public function __construct(AlunoPacote $alunoPacote, $pacoteAntigoId)
    {
        $this->alunoPacote = $alunoPacote;
        $this->pacoteAntigoId = $pacoteAntigoId;
    }
}
