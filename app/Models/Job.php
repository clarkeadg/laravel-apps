<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'title',
        'location',
        'remote',
        'type',
        'benefits',
        'compensation',
        'description',
        'source_url',
        'posted_date'
    ];

    protected $hidden = [
        //'created_at',
        //'updated_at',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
