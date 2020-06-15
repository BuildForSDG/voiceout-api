<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Report extends Model implements HasMedia 
{

    use InteractsWithMedia;

	protected $guarded = [];
    protected $appends = ['media_url', 'upvoted', 'downvoted', 'status'];
    
    protected $hidden = ['media', 'user_id'];


    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function sector() {
    	return $this->belongsToMany(Sector::class)->withTimestamps();
    }

    public function votes() {
    	return $this->belongsToMany(User::class, 'votes')->withPivot('vote');

        // return $vote->count();
    }


    public function comments() {
        return $this->hasMany(Comment::class);
    }


    // public function getTotalVotesAttribute() {
    //   $vote = $this->votes();
    //   return $vote->count();
    // }

    public function getUpvotedAttribute() {
        $votes = $this->votes()->where('vote', true)->get();
        return $votes->pluck('id');

        // $vote = $this->votes()
        // return $vote;

        // if ($vote) {
        //     return true;
        // } else {
        //     return false;
        // }
    }

    public function getDownvotedAttribute() {
        $votes = $this->votes()->where('vote', false)->get();
        return $votes->pluck('id');

    }


    // public function getReasonAttribute() {
    //     $votes = $this->votes()->firstWhere('vote', false);
    //     return $votes->reason();
    // }

    public function getStatusAttribute() {
        $user = auth('sanctum')->user();

        if (!$user) {
            return 'user not logged in';
        }
        
        // dd($vote_data);
        $user_id = $user->id;
        if ($this->user_id == $user_id ) {
            return 'creator';
        } else {
            $vote_data = $this->votes()->firstWhere( 'user_id', $user_id );

            if (!$vote_data) {
                return 'not voted';
            } else {

                // dd($vote_data->pivot->vote);

                if ($vote_data->pivot->vote == true) {
                    return 'upvoted';
                } else {
                    return 'downvoted';
                }
            }


        }

      


  
    }


 public function registerMediaCollections(): void {
         $this->addMediaCollection('images');
         $this->addMediaCollection('videos');
    }

 public function getMediaUrlAttribute() {

        $images = $this->getMedia('images');
        $videos = $this->getMedia('videos');

        $imagesUrl = null;
        $videosUrl = null;
        
        foreach($images as $image) {
            $imagesUrl[] = $image->getUrl();
        }

        // dd($imagesUrl);

        

        foreach($videos as $video) {
            $videosUrl[] = $video->getUrl();

        }
        // dd($videosUrl);

        // dd($imagesUrl);

        $media = [

            'images' => $imagesUrl,
            'videos' => $videosUrl
        ];

        return $media;


        // $media->each( function($item, $key ) {
        //     $imagesUrl[] = $item->getUrl();

        //     // dd($item->getUrl());
        // }); 

        // dd($imagesUrl);
    }


}
