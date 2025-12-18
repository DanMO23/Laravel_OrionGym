<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User; // Added this line

class GympassCheckin extends Model
{
    protected $fillable = [
        'gympass_id',
        'user_id',
        'status',
        'response_data',
    ];

    protected $casts = [
        'response_data' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
