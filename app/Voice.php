<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Voice extends Model
{

	protected $guarded = [];
	// protected $with = ['user'];


	public function reports() {
		return $this->belongsToMany(Report::class);
	}
}
