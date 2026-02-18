<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Aluno;
use App\Models\Pacote;
use App\Models\AlunoPacote;
use App\Models\AlunosVencidos;
use Illuminate\Support\Facades\DB;

class VencidosDancaTestSeeder extends Seeder
{
    public function run(): void
    {
        // ── Pacotes ──
        $pacotes = [
            ['nome_pacote' => 'Dança',                    'valor' => 89.90,  'validade' => 30],
            ['nome_pacote' => 'Dança + Ritmos',            'valor' => 109.90, 'validade' => 30],
            ['nome_pacote' => 'Dança Kids',                'valor' => 79.90,  'validade' => 30],
            ['nome_pacote' => 'Musculação + Dança',        'valor' => 149.90, 'validade' => 30],
            ['nome_pacote' => 'Musculação',                'valor' => 99.90,  'validade' => 30],
            ['nome_pacote' => 'Musculação Trimestral',     'valor' => 259.90, 'validade' => 90],
        ];

        $pacoteIds = [];
        foreach ($pacotes as $p) {
            $existing = Pacote::where('nome_pacote', $p['nome_pacote'])->first();
            $pacoteIds[$p['nome_pacote']] = $existing ? $existing->id : Pacote::create($p)->id;
        }

        // ── Alunos mock ──
        $alunosMock = [
            // Dança exclusivo (devem aparecer na página Dança)
            ['nome' => 'Ana Carolina Silva',    'email' => 'ana.carolina@test.com',   'telefone' => '(11) 99999-1001', 'data_nascimento' => '1998-03-15', 'cpf' => '111.111.111-01', 'sexo' => 'F', 'endereco' => 'Rua das Flores, 100',   'pacote' => 'Dança'],
            ['nome' => 'Beatriz Oliveira',      'email' => 'beatriz.oli@test.com',    'telefone' => '(11) 99999-1002', 'data_nascimento' => '2001-07-22', 'cpf' => '111.111.111-02', 'sexo' => 'F', 'endereco' => 'Av. Brasil, 200',       'pacote' => 'Dança'],
            ['nome' => 'Camila Ferreira',       'email' => 'camila.fer@test.com',     'telefone' => '(11) 99999-1003', 'data_nascimento' => '1995-11-08', 'cpf' => '111.111.111-03', 'sexo' => 'F', 'endereco' => 'Rua Alegria, 300',      'pacote' => 'Dança + Ritmos'],
            ['nome' => 'Diego Martins',         'email' => 'diego.mart@test.com',     'telefone' => '(11) 99999-1004', 'data_nascimento' => '2000-01-30', 'cpf' => '111.111.111-04', 'sexo' => 'M', 'endereco' => 'Rua São Paulo, 400',    'pacote' => 'Dança + Ritmos'],
            ['nome' => 'Eduarda Costa',         'email' => 'eduarda.costa@test.com',  'telefone' => '(11) 99999-1005', 'data_nascimento' => '2003-05-12', 'cpf' => '111.111.111-05', 'sexo' => 'F', 'endereco' => 'Av. Central, 500',      'pacote' => 'Dança Kids'],
            ['nome' => 'Fernanda Lima',         'email' => 'fernanda.l@test.com',     'telefone' => '(11) 99999-1006', 'data_nascimento' => '1997-09-25', 'cpf' => '111.111.111-06', 'sexo' => 'F', 'endereco' => 'Rua da Paz, 600',       'pacote' => 'Dança Kids'],

            // Musculação + Dança (devem aparecer na vencidos NORMAL, não na de dança)
            ['nome' => 'Gabriel Santos',        'email' => 'gabriel.s@test.com',      'telefone' => '(11) 99999-1007', 'data_nascimento' => '1996-04-18', 'cpf' => '111.111.111-07', 'sexo' => 'M', 'endereco' => 'Rua do Forte, 700',     'pacote' => 'Musculação + Dança'],
            ['nome' => 'Helena Rodrigues',      'email' => 'helena.rod@test.com',     'telefone' => '(11) 99999-1008', 'data_nascimento' => '1999-12-03', 'cpf' => '111.111.111-08', 'sexo' => 'F', 'endereco' => 'Av. Liberdade, 800',    'pacote' => 'Musculação + Dança'],

            // Musculação (devem aparecer na vencidos normal)
            ['nome' => 'Igor Almeida',          'email' => 'igor.alm@test.com',       'telefone' => '(11) 99999-1009', 'data_nascimento' => '1994-08-20', 'cpf' => '111.111.111-09', 'sexo' => 'M', 'endereco' => 'Rua Esporte, 900',      'pacote' => 'Musculação'],
            ['nome' => 'Julia Nascimento',      'email' => 'julia.nasc@test.com',     'telefone' => '(11) 99999-1010', 'data_nascimento' => '2002-02-14', 'cpf' => '111.111.111-10', 'sexo' => 'F', 'endereco' => 'Rua Vitória, 1000',     'pacote' => 'Musculação'],
            ['nome' => 'Kauan Pereira',         'email' => 'kauan.per@test.com',      'telefone' => '(11) 99999-1011', 'data_nascimento' => '2000-06-07', 'cpf' => '111.111.111-11', 'sexo' => 'M', 'endereco' => 'Av. Saúde, 1100',       'pacote' => 'Musculação Trimestral'],
            ['nome' => 'Larissa Mendes',        'email' => 'larissa.m@test.com',      'telefone' => '(11) 99999-1012', 'data_nascimento' => '1993-10-29', 'cpf' => '111.111.111-12', 'sexo' => 'F', 'endereco' => 'Rua Energia, 1200',     'pacote' => 'Musculação Trimestral'],
        ];

        foreach ($alunosMock as $mock) {
            // Verifica se CPF já existe
            if (Aluno::where('cpf', $mock['cpf'])->exists()) {
                continue;
            }

            $pacoteNome = $mock['pacote'];
            unset($mock['pacote']);

            // Criar aluno com dias_restantes = 0 e matrícula inativa
            $mock['dias_restantes'] = 0;
            $aluno = Aluno::create($mock);
            $aluno->matricula_ativa = 'inativa';
            $aluno->save();

            // Criar compra (aluno_pacote)
            AlunoPacote::create([
                'aluno_id'            => $aluno->id,
                'pacote_id'           => $pacoteIds[$pacoteNome],
                'descricao_pagamento' => 'Pagamento via PIX - Teste',
                'valor_pacote'        => $pacotes[array_search($pacoteNome, array_column($pacotes, 'nome_pacote'))]['valor'],
                'dias_totais'         => $pacotes[array_search($pacoteNome, array_column($pacotes, 'nome_pacote'))]['validade'],
            ]);

            // Inserir na tabela de vencidos
            AlunosVencidos::create([
                'aluno_id'         => $aluno->id,
                'nome'             => $aluno->nome,
                'email'            => $aluno->email,
                'telefone'         => $aluno->telefone,
                'sexo'             => $aluno->sexo,
                'numero_matricula' => $aluno->numero_matricula,
                'matricula_ativa'  => 'inativa',
            ]);
        }

        $this->command->info('✅ Dados de teste inseridos com sucesso!');
        $this->command->info('   → 6 alunos de Dança exclusivo (Dança, Dança + Ritmos, Dança Kids)');
        $this->command->info('   → 2 alunos de Musculação + Dança (vão para vencidos normal)');
        $this->command->info('   → 4 alunos de Musculação (vão para vencidos normal)');
    }
}
