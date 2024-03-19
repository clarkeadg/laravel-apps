<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileData extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',      
        'values',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'values' => 'json'
    ];
}
