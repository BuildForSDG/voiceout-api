<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Report extends Model 
{
    
    public function user() {
    	return $this->belongsTo(User::class);
    }

    public function institution() {
    	return $this->belongsTo(Institution::class);
    }
}
