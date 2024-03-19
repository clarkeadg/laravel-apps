<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Tag extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function toSearchableArray(): array
    {
        return [
            'id'   => $this->getKey(), // this *must* be defined
            'name' => $this->name,
        ];
    }

    public function items() {
        return $this->hasMany(TagItem::class);
    }
}
