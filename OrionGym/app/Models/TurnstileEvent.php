<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TurnstileEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_type',
        'user_id',
        'user_name',
        'card_number',
        'direction',
        'timestamp',
        'success',
        'reason'
    ];

    protected $casts = [
        'timestamp' => 'datetime',
        'success' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
