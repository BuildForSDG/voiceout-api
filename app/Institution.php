<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model 
{

	   protected $guarded = [];

       public function reports() {
       		return $this->hasMany(Report::class);
       }

       public function owner() {
       		return $this->hasOne(User::class, 'Institution_owned');
       }

       public function followers() {
       		return $this->belongsToMany(User::class)->withTimestamps();
       }
}
