<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;


class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, Notifiable, InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    // protected $appends = ['url'];


    // protected $with = ['voice', 'institution'];



    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reports() {
        return $this->hasMany(Report::class);
    }

    public function votes() {
        return $this->belongsToMany(Report::class, 'votes')->withPivot('vote');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    // public function votes() {
    //     return $this->belongsToMany(Report::class);
    // }



    // public function getUrlAttribute() {
    //     $images = $this->getMedia('images');
    //      foreach($images as $image) {
    //         $imagesUrl[] = $image->getUrl();

    //     }
    //     dd($this->getFirstMediaUrl('images'));
    // }

}
