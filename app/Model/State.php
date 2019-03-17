<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
		'state_name_ar',
		'state_name_en',
		'country_id',
		'city_id',
	];

	public function country() {
		return $this->belongsTO('App\Model\Country');
	}

	public function city() {
		return $this->belongsTO('App\Model\City');
	}
}
