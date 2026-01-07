<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Professor extends Model
{
    protected $table = 'professores';
    protected $fillable = [
        'numero_matricula',
        'nome_completo',
        'cpf',
        'email',
        'telefone',
        'endereco',
        'sexo',
        'cargo',
        'foto',
        'tipo'
    ];

    public function alunosPersonal()
    {
        return $this->hasMany(AlunoPersonal::class);
    }

    // Gerar próximo número de matrícula
    public static function gerarProximaMatricula()
    {
        $ultimaMatricula = self::where('numero_matricula', 'like', '8%')
            ->orderBy('numero_matricula', 'desc')
            ->first();

        if ($ultimaMatricula) {
            return (int)$ultimaMatricula->numero_matricula + 1;
        }

        return 8000;
    }
}
