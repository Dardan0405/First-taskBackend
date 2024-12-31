<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class AdminDetails extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'address',
        'city',
        'state',
        'zip',
        'country',
        'profile_completeness',
        'second_address'
    ];

    public function user()
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }
}
