<?php

namespace App\Exports;

use App\Models\Aluno;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class AlunosExport implements FromCollection, WithHeadings
{
    /**
     * Retorna a coleção de alunos para exportar
     */
    public function collection()
    {
        return Aluno::select('numero_matricula', 'nome', 'email', 'telefone', 'sexo', 'dias_restantes', 'matricula_ativa')->get();
    }

    /**
     * Define os títulos das colunas
     */
    public function headings(): array
    {
        return [
            'Matrícula',
            'Nome',
            'Email',
            'Telefone',
            'Sexo',
            'Dias Restantes',
            'Status',
        ];
    }
}
