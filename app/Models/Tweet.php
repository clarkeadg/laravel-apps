<?php

namespace App\Models;

use App\Events\TweetCreated;
use App\Events\TweetUpdated;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use GrahamCampbell\Markdown\Facades\Markdown;
use Laravel\Scout\Searchable;

class Tweet extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, Searchable;

    protected $fillable = [
        'user_id',
        'content',
        'parent_id',
        'repost_id',
        'sensitive',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'user_id',
        'content',
        'media'
    ];

    protected $appends = [
        'parsed_content',
        'created_time',
        'comments_count',
        'reposts_count',
        'blocked',
        'muted',
        'photos',
    ]; 

    protected $dispatchesEvents = [
        'created' => TweetCreated::class,
        'updated' => TweetUpdated::class,
    ];

    public function toSearchableArray(): array
    {
        return [
            'id'   => $this->getKey(), // this *must* be defined
            'user_id' => $this->user_id,
            'content' => $this->content,
        ];
    }

    public function getParsedContentAttribute() {
        // convert to markdown
        $content = Markdown::convert($this->content)->getContent();
        
        // parse links
        $content = preg_replace(
            "~[[:alpha:]]+://[^<>[:space:]]+[[:alnum:]/]~",
            '<a class="text-blue-500 hover:underline" rel="nofollow noopener" target="_blank" href="\\0">\\0</a>',
            $content);

        // parse hashtags
        $content = preg_replace(
            '/#(\w+)/',
            '<a class="text-blue-500 hover:underline" href="/tag/$1">#$1</a>',
            $content);

        // parse mentions
        $content = preg_replace(
            '/@(\w+)/',
            '<a class="text-blue-500 hover:underline" href="/@$1">@$1</a>',
            $content);

        return $content;
    }

    public function getCreatedTimeAttribute() {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getCommentsCountAttribute() {
        return $this->comments()->count();
    }

    public function getRepostsCountAttribute() {
        return $this->reposts()->count();
    }

    public function getBlockedAttribute() {
        $blocked = false;

        $user = Auth::user();
        if (isset($user)) {            
            
            $reaction = Reaction::where('user_id', $user->id)
                            ->where('name', 'mute')
                            ->where('object_type', 'App\Models\User')
                            ->where('object_id', $this->user->id)
                            ->get()->first();

            if(isset($reaction)) {
                $blocked = true;
            }            
        }
        return $blocked;
    }

    public function getMutedAttribute() {
        $muted = false;

        $user = Auth::user();
        if (isset($user)) {            
            
            $reaction = Reaction::where('user_id', $user->id)
                            ->where('name', 'mute')
                            ->where('object_type', 'App\Models\User')
                            ->where('object_id', $this->user->id)
                            ->get()->first();

            if(isset($reaction)) {
                $muted = true;
            }            
        }
        return $muted;
    }    

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reactions(): MorphMany
    {
        return $this->morphMany(Reaction::class, 'object');
    }

    public function parent()
    {
        return $this->belongsTo(Tweet::class, 'parent_id');
    }

    public function comments()
    {
        return $this->hasMany(Tweet::class, 'parent_id');
    }

    public function original()
    {
        return $this->belongsTo(Tweet::class, 'repost_id');
    }

    public function reposts()
    {
        return $this->hasMany(Tweet::class, 'repost_id');
    }

    public function reports()
    {
        return $this->morphMany(Report::class, 'object');
    }

    public function tag_items()
    {
        return $this->morphMany(TagItem::class, 'object');
    }    

    public function getPhotosAttribute() {
        return $this->getMedia('photos');
    }    

    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('photos')
            ->registerMediaConversions(function (Media $media) {
                $this
                    ->addMediaConversion('thumb')
                    ->width(500)
                    ->height(500)
                    ->nonQueued();
            });
    } 
}
