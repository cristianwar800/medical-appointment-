// En el microservicio: app/Models/ChatMessage.php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = [
        'session_id',
        'message',
        'type',
        'user_type',
        'intent',
        'context',
        'resolved'
    ];

    protected $casts = [
        'context' => 'array',
        'resolved' => 'boolean'
    ];

    // Scope para mensajes del bot
    public function scopeBot($query)
    {
        return $query->where('type', 'bot');
    }

    // Scope ppara mensajes del usuario
    public function scopeUser($query)
    {
        return $query->where('type', 'user');
    }

    // Scope para filtrar por tipo de usuario
    public function scopeByUserType($query, $userType)
    {
        return $query->where('user_type', $userType);
    }
}