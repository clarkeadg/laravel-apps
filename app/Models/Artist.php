<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Artist extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'ytid',
        'videos_count'
    ];

    public function toSearchableArray(): array
    {
        return [
            'id'   => $this->getKey(), // this *must* be defined
            'name' => $this->name,
            //'slug' => $this->slug,
        ];
    }

    public function getThumbnailAttribute() {
        return "https://img.youtube.com/vi/".$this->ytid."/mqdefault.jpg";
    }

    public function getImageAttribute() {
        return "https://img.youtube.com/vi/".$this->ytid."/maxresdefault.jpg";
    }

    public function getVideosCountAttribute() {
        return $this->videos()->count();
    }

    public function videos()
    {
        return $this->hasMany(Video::class);
    }

    public function getYtidAttribute(){
        $video = $this->videos()
            ->orderBy("id", "desc")
            ->first();
        return isset($video) ? $video->ytid : "";
    }
}
