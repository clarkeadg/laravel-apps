<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'order',
        'type'
    ];

    protected $hidden = [
        'order',
        'type',
        'created_at',
        'updated_at',
    ];

    public function getThumbnailAttribute() {
        return "https://img.youtube.com/vi/".$this->ytid."/mqdefault.jpg";
    }

    public function getImageAttribute() {
        return "https://img.youtube.com/vi/".$this->ytid."/maxresdefault.jpg";
    }

    public function getVideosCountAttribute() {
        return $this->videos()->count();
    }

    public function videos(){
        return $this->belongsToMany(Video::class, 'video_category', 'category_id', 'video_id');
    }

    public function getYtidAttribute(){
        $video = $this->videos()
            ->orderBy("id", "desc")
            ->first();
        return isset($video) ? $video->ytid : "";
    }

}
