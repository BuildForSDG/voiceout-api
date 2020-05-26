<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Report extends Model implements HasMedia 
{

    use InteractsWithMedia;

	protected $guarded = [];
    protected $appends = ['media_url'];
    protected $hidden = ['media', 'user_id', 'institution_id'];


    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function institution() {
    	return $this->belongsTo(Institution::class);
    }

    public function votes() {
    	return $this->hasMany(Vote::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
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
