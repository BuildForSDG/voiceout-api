<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Institution extends Model 
{
       public function reports() {
       		return $this->hasMany(Report::class);
       }

       public function user() {
       		return $this->hasOne(User::class);
       }
}
