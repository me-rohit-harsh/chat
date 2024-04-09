<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Conversation;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'user_id', 'department', 'category', 'message', 'admin_reply', 'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversations()
    {
        return $this->hasMany(Conversation::class);
    }
}


