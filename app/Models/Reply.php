<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    use HasFactory;

    protected $fillable = [
        'thread_id',
        'user_id',
        'reply_content',
    ];

    // Relationship to the thread
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    // Relationship to the user who created the reply
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}

