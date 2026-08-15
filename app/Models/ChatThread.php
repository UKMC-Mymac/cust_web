<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatThread extends Model
{
    protected $fillable = [
        'chat_id',
        'visitor_name',
        'visitor_email',
        'visitor_phone',
        'assigned_admin_id',
        'status',
        'last_message_at',
    ];

    protected $casts = [
        'last_message_at' => 'datetime',
    ];

    public function messages()
    {
        return $this->hasMany(ChatMessage::class, 'thread_id');
    }

    public function assignedAdmin()
    {
        return $this->belongsTo(\App\User::class, 'assigned_admin_id');
    }
}
