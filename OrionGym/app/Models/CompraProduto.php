<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompraProduto extends Model
{
    use HasFactory;

    protected $table = 'compras';
    protected $fillable = [
        'produto_id',
        'comprador',
        'quantidade',
        'valor_total'
    ];

    public function produto()
    {
        return $this->belongsTo(Produto::class, 'produto_id');
    }
    
}
