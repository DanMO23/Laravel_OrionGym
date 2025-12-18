<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnstileCommand extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'data',
        'status',
        'result_message',
        'completed_at'
    ];

    protected $casts = [
        'completed_at' => 'datetime',
    ];
}
