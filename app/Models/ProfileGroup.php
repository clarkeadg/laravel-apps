<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProfileGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'group_order',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function profile_fields()
    {
        return $this->hasMany(ProfileField::class)->orderBy('field_order', 'asc');
    }

    public function getCountAttribute(){
        return $this->profile_fields()->count();
    }
}
