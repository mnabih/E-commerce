<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Trademark extends Model
{
    protected $fillable = [
		'name_ar',
		'name_en',
		'logo',
	];
}
