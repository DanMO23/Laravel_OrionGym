<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Funcionario extends Model
{
    protected $fillable = ['nome_completo', 'email', 'sexo', 'cargo', 'foto'];
}
