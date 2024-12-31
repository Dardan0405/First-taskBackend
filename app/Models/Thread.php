<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    use HasFactory;

    // Specify the table name
    protected $table = 'thread';

    protected $fillable = [
        'thread_title',
        'thread_description',
    ];
}
