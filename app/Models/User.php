<?php

namespace App\Models;

use Carbon\Carbon;
use Cmgmyr\Messenger\Traits\Messagable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
//use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Laravel\Scout\Searchable;

class User extends Authenticatable implements FilamentUser, HasMedia, JWTSubject, MustVerifyEmail
{
    use HasApiTokens,
    HasFactory,
    HasProfilePhoto,
    Messagable,
    Notifiable,
    InteractsWithMedia,
    Searchable;
    //TwoFactorAuthenticatable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'photo_id',
        'cover_photo_id',
    ];

    protected $hidden = [
        'id',
        'email',
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
        'email_verified_at',
        'current_team_id',
        'profile_photo_path',
        'created_at',
        'updated_at',
        'two_factor_confirmed_at',
        'photo_id',
        'cover_photo_id',
        'media',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $appends = [
        'avatar',
        'cover_photo',
        'joined_date',
    ];

    protected $with = [
        'media',
        'profile_data'
    ];
    
    public function toSearchableArray(): array
    {
        $results = [
            'id'   => $this->getKey(), // this *must* be defined
            'name' => $this->name,
            'hasPhoto' => isset($this->photo_id) ? true : false,
        ];

        foreach($this->profile_data as $data) {
            foreach($data['values'] as $values) {
                $results[str_replace(" ", "_", $values['name'])] = $values['value'];
            }
        }
        
        return $results;
    }

    // Activities

    // Blocks
    public function getBlockedAttribute() {
        $blocked = false;

        $user = Auth::user();
        if (isset($user)) {            
            
            $reaction = Reaction::where('user_id', $user->id)
                            ->where('name', 'block')
                            ->where('object_type', 'App\Models\User')
                            ->where('object_id', $this->id)
                            ->get()->first();

            if(isset($reaction)) {
                $blocked = true;
            }            
        }
        return $blocked;
    }

    public function getBlockedMeAttribute() {
        $blocked = false;

        $user = Auth::user();
        if (isset($user)) {            
            
            $reaction = Reaction::where('user_id', $this->id)
                            ->where('name', 'block')
                            ->where('object_type', 'App\Models\User')
                            ->where('object_id', $user->id)
                            ->get()->first();

            if(isset($reaction)) {
                $blocked = true;
            }            
        }
        return $blocked;
    }

    public function activities()
    {
        return $this->morphMany(UserActivity::class, 'object');
    }

    // Filament User
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            //return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail()
            return ($this->email == 'clarkeadg@yahoo.com') && $this->hasVerifiedEmail();
            //return ($this->email == 'clarkeadg@yahoo.com' || $this->email == 'demo@demo.com') && $this->hasVerifiedEmail();
        }
        
        return true;
    }    

    // Joined Date
    public function getJoinedDateAttribute() {
        return Carbon::parse($this->created_at)->format('M Y');
    }

    // JWT

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // Followers

    public function getFollowersCountAttribute() {
        return Reaction::where('object_id', $this->id)
            ->where('name', 'follow')
            ->where('object_type', 'App\Models\User')
            ->count();
    }

    public function getFollowingCountAttribute() {
        return Reaction::where('user_id', $this->id)
            ->where('name', 'follow')
            ->where('object_type', 'App\Models\User')
            ->count();
    }

    // Media (photos)

    public function getAvatarAttribute() {
        $photo = $this->getMedia('photos')->where('id', $this->photo_id)->first();
        return isset($photo) ? $photo->getUrl() : "/images/avatar.png";
    }

    public function getAvatarIndexAttribute() {
        $avatarIndex = 0;
        for($i=0;$i<count($this->photos);$i++) {
            if ($this->photo_id == $this->photos[$i]->id) {
                $avatarIndex = $i;
            }
        }
        return $avatarIndex;
    }

    public function getAvatarThumbAttribute() {
        $photo = $this->getMedia('photos')->where('id', $this->photo_id)->first();
        return isset($photo) ? $photo->getUrl('thumb') : "/images/avatar.png";
    }

    public function getCoverPhotoAttribute() {
        $photo = $this->getMedia('photos')->where('id', $this->cover_photo_id)->first();
        return isset($photo) ? $photo->getUrl() : "/images/cover.jpg";
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
                    ->width(200)
                    ->height(200);
            });
    }    

    // Meta    

    public function meta() {
        return $this->hasMany(UserMeta::class);
    }

    // Mutes
    public function getMutedAttribute() {
        $muted = false;

        $user = Auth::user();
        if (isset($user)) {            
            
            $reaction = Reaction::where('user_id', $user->id)
                            ->where('name', 'mute')
                            ->where('object_type', 'App\Models\User')
                            ->where('object_id', $this->id)
                            ->get()->first();

            if(isset($reaction)) {
                $muted = true;
            }            
        }
        return $muted;
    }

    public function getHideRepostsAttribute() {
        $hide = false;

        $user = Auth::user();
        if (isset($user)) {            
            
            $reaction = Reaction::where('user_id', $user->id)
                            ->where('name', 'hide_reposts')
                            ->where('object_type', 'App\Models\User')
                            ->where('object_id', $this->id)
                            ->get()->first();

            if(isset($reaction)) {
                $hide = true;
            }            
        }
        return $hide;
    }

    // Notifications

    public function notifications() {
        return $this->morphMany(Notification::class, 'object');
    }    

    // Profile

    public function profile_data() {
        return $this->hasMany(ProfileData::class);
    }

    public function getIsMyProfileAttribute() {
        return (Auth::user() && $this->name == Auth::user()->name) ? true : false;
    }

    // Reactions

    public function reactions() {
        return $this->morphMany(Reaction::class, 'object');
    }

    // Reports

    public function reports() {
        return $this->morphMany(Report::class, 'object');
    }

    // Tweets

    public function tweets() {
        return $this->hasMany(Tweet::class);
    }

    // Twitter Profile

    private function getProfileData($group_name, $field_name) {
        $results = null;

        // get profile groups
        $profile_groups_data = ProfileGroup::with('profile_fields')->get();
        $profile_groups = [];
        foreach($profile_groups_data as $profile_group) {
            $profile_groups[$profile_group->name] = $profile_group->profile_fields; 
        }
        
        $profile_data = [];
        foreach($this->profile_data as $data) {
            foreach($data['values'] as $values) {
                $profile_data[$values['title']] = $values['value'];
            }
        }

        //dd($profile_data);
 
        foreach ($profile_groups[$group_name] as $field) {
            if(isset($profile_data[$field->title])) {
                if($field->title == $field_name) {
                    $results = $profile_data[$field->title];
                }
            }
        }

        return $results;
    }

    public function getTwitterDisplayNameAttribute() {
        $display_name = $this->getProfileData("TwitterProfile", "Display Name");
        if (!isset($display_name)) {
            $display_name = $this->name;
        }
        return $display_name;
    }

    public function getTwitterBioAttribute() {
        return $this->getProfileData("TwitterProfile", "Bio");
    }

}
