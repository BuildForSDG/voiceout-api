<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model 
{
	protected $guarded = [];


    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function institution() {
    	return $this->belongsTo(Institution::class);
    }

    public function votes() {
    	return $this->hasMany(Vote::class);
    }
}
