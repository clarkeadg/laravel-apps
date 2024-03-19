<?php

namespace App\Models;

use App\Events\ReactionUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Reaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'object_type',
        'object_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id',
        'name',
        'object_type',
        'object_id',
    ];

    protected $dispatchesEvents = [
        'created' => ReactionUpdated::class,
        'deleting' => ReactionUpdated::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function object(): MorphTo
    {
        return $this->morphTo();
    }
}
