<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionnaireSession extends Model
{
    protected $fillable = [
        'session_id',
        'name',
        'id_card',
        'phone',
        'answers',
        'expires_at'
    ];

    protected $casts = [
        'answers' => 'array',
        'expires_at' => 'datetime'
    ];
}
