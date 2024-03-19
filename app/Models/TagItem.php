<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class TagItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tag_id',
        'object_type',
        'object_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }

    public function object(): MorphTo
    {
        return $this->morphTo();
    }
}
