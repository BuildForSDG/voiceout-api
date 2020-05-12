<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
	protected $guarded = [];

	public function user() {
		return $this->belongsTo(User::class);
	}

	public function report() {
		return $this->belongsTo(Report::class);
	}
}
