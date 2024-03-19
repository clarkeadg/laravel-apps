<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileField extends Model
{
    use HasFactory;

    protected $fillable = [
        'profile_group_id',      
        'name',
        'title',
        'placeholder',
        'description',
        'type',
        'is_required',        
        'field_order',
        'options'
    ];

    protected $casts = [
        'options' => 'json'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];    
}
