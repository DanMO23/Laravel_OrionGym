<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class AlunoPersonal extends Model
{
    use SoftDeletes;

    protected $table = 'alunos_personal';
    
    protected $fillable = [
        'professor_id',
        'nome_completo',
        'tipo_aluno',
        'aluno_id',
        'telefone',
        'email',
        'data_vencimento',
        'dia_vencimento',
        'ultimo_pagamento',
        'valor_mensalidade',
        'status',
        'status_pagamento',
        'dias_restantes',
        'observacoes'
    ];

    protected $casts = [
        'data_vencimento' => 'date',
        'ultimo_pagamento' => 'date',
        'valor_mensalidade' => 'decimal:2',
        'dia_vencimento' => 'integer'
    ];

    protected $attributes = [
        'status' => 'ativo',
        'status_pagamento' => 'pendente'
    ];

    public function professor()
    {
        return $this->belongsTo(Professor::class);
    }

    public function aluno()
    {
        return $this->belongsTo(Aluno::class);
    }

    // Calcular próximo vencimento baseado no dia fixo
    public function getProximoVencimentoAttribute()
    {
        $hoje = Carbon::now();
        $diaVencimento = $this->dia_vencimento ?? 10;
        
        // Garantir que o dia não seja maior que 28 para evitar problemas com meses curtos
        $diaVencimento = min($diaVencimento, 28);
        
        // Se o dia do vencimento já passou este mês, calcular para o próximo mês
        if ($hoje->day > $diaVencimento) {
            return Carbon::create($hoje->year, $hoje->month, 1)
                ->addMonth()
                ->day($diaVencimento);
        }
        
        return Carbon::create($hoje->year, $hoje->month, $diaVencimento);
    }

    // Calcular o início do ciclo atual de pagamento
    public function getInicioCicloAtualAttribute()
    {
        $hoje = Carbon::now();
        $diaVencimento = $this->dia_vencimento ?? 10;
        $diaVencimento = min($diaVencimento, 28);
        
        // O ciclo começa no dia de vencimento do mês anterior
        if ($hoje->day >= $diaVencimento) {
            // Estamos após o vencimento deste mês, então o ciclo atual começou neste mês
            return Carbon::create($hoje->year, $hoje->month, $diaVencimento);
        } else {
            // Ainda não chegou o vencimento deste mês, ciclo começou no mês anterior
            return Carbon::create($hoje->year, $hoje->month, 1)
                ->subMonth()
                ->day($diaVencimento);
        }
    }

    // Calcular dias restantes até o próximo vencimento
    public function getDiasRestantesAttribute()
    {
        $hoje = Carbon::now()->startOfDay();
        $proximoVencimento = $this->proximo_vencimento->startOfDay();
        
        $dias = $hoje->diffInDays($proximoVencimento, false);
        
        return max($dias, 0);
    }

    // Verificar se está vencido
    public function getVencidoAttribute()
    {
        return $this->dias_restantes == 0 && $this->status_pagamento != 'pago';
    }

    // Verificar se o pagamento do ciclo atual foi feito
    public function isPagoCicloAtual()
    {
        if (!$this->ultimo_pagamento) {
            return false;
        }
        
        $ultimoPagamento = Carbon::parse($this->ultimo_pagamento);
        $inicioCiclo = $this->inicio_ciclo_atual;
        
        // O pagamento é válido se foi feito após o início do ciclo atual
        return $ultimoPagamento->gte($inicioCiclo);
    }

    // Registrar pagamento
    public function registrarPagamento()
    {
        $this->ultimo_pagamento = Carbon::now();
        $this->status_pagamento = 'pago';
        
        // Calcular próximo vencimento (próximo mês)
        $proximoVencimento = $this->proximo_vencimento->copy()->addMonth();
        $this->data_vencimento = $proximoVencimento;
        
        $this->save();
    }

    // Atualizar status de pagamento automaticamente
    public function atualizarStatusPagamento()
    {
        $hoje = Carbon::now();
        $diaVencimento = $this->dia_vencimento ?? 10;
        
        // Verificar se o pagamento do ciclo atual foi feito
        if ($this->isPagoCicloAtual()) {
            $this->status_pagamento = 'pago';
        } else {
            // Verificar se já passou o dia de vencimento
            $vencimentoAtual = $this->proximo_vencimento;
            
            if ($hoje->gt($vencimentoAtual)) {
                $this->status_pagamento = 'atrasado';
            } else {
                $this->status_pagamento = 'pendente';
            }
        }
        
        // Calcular dias restantes e salvar
        $this->dias_restantes = $this->dias_restantes;
        
        $this->save();
    }
}
