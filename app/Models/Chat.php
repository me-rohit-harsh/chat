<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','user_id','department','category', 'message', 'admin_reply', 'sender_id', 'status',
    ];
}

