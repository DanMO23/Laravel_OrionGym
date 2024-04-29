<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professor extends Model
{
    protected $table = 'professores';
    protected $fillable = ['nome_completo', 'email', 'telefone', 'endereco', 'sexo', 'cargo', 'foto'];
}
