<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Video extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'slug',
        'ytid',
        'artist_id'
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $with = [
        'artist',
    ];

    public function toSearchableArray(): array
    {
        return [
            'id'   => $this->getKey(), // this *must* be defined
            'name' => $this->name,
            'slug' => $this->slug,
        ];
    }

    public function artist()
    {
        return $this->belongsTo(Artist::class);
    }

    public function getThumbnailAttribute() {
        return "https://img.youtube.com/vi/".$this->ytid."/mqdefault.jpg";
    }

    public function getImageAttribute() {
        //return "https://img.youtube.com/vi/".$this->ytid."/maxresdefault.jpg";
        return "https://img.youtube.com/vi/".$this->ytid."/hqdefault.jpg";
    }

    public function categories(){
        return $this->belongsToMany(Category::class, 'video_category', 'video_id', 'category_id');
    }

    public function activities()
    {
        return $this->morphMany(UserActivity::class, 'object');
    }

    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'object');
    }
}
