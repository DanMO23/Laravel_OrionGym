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
        'cpf',
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
        $diaVencimento = $this->dia_vencimento;
        
        // Se o dia do vencimento já passou este mês, calcular para o próximo mês
        if ($hoje->day > $diaVencimento) {
            return Carbon::create($hoje->year, $hoje->month, 1)
                ->addMonth()
                ->addDays($diaVencimento - 1);
        }
        
        return Carbon::create($hoje->year, $hoje->month, $diaVencimento);
    }

    // Calcular dias restantes até o próximo vencimento
    public function getDiasRestantesAttribute()
    {
        $hoje = Carbon::now()->startOfDay();
        $proximoVencimento = $this->proximo_vencimento->startOfDay();
        
        $dias = $hoje->diffInDays($proximoVencimento, false);
        
        return $dias >= 0 ? $dias : 0;
    }

    // Verificar se está vencido
    public function getVencidoAttribute()
    {
        return $this->dias_restantes == 0 && $this->status_pagamento != 'pago';
    }

    // Verificar se o pagamento está atrasado
    public function getAtrasadoAttribute()
    {
        if (!$this->ultimo_pagamento) {
            return true;
        }

        $ultimoPagamento = Carbon::parse($this->ultimo_pagamento);
        $hoje = Carbon::now();
        
        return $ultimoPagamento->diffInDays($hoje) > 35;
    }

    // Registrar pagamento
    public function registrarPagamento()
    {
        $this->ultimo_pagamento = Carbon::now();
        $this->status_pagamento = 'pago';
        
        // Calcular próximo vencimento
        $hoje = Carbon::now();
        $proximoVencimento = Carbon::create($hoje->year, $hoje->month, 1)
            ->addMonth()
            ->addDays($this->dia_vencimento - 1);
            
        $this->data_vencimento = $proximoVencimento;
        
        $this->save();
    }

    // Atualizar status de pagamento automaticamente
    public function atualizarStatusPagamento()
    {
        $hoje = Carbon::now();
        $vencimento = $this->proximo_vencimento;
        
        if ($this->ultimo_pagamento && Carbon::parse($this->ultimo_pagamento)->isCurrentMonth()) {
            $this->status_pagamento = 'pago';
        } elseif ($hoje->isAfter($vencimento)) {
            $this->status_pagamento = 'atrasado';
        } else {
            $this->status_pagamento = 'pendente';
        }
        
        $this->save();
    }
}
