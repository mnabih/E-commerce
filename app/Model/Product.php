<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    	'photo',
    	'content',
    	'price',
    	'stock',
    	'start_at',
    	'end_at',
    	'price_offer',
    	'start_offer_at',
    	'end_offer_at',
    	'department_id',
    	'manu_id',
    	'color_id',
    	'size',
    	'size_id',
    	'weight',
    	'weight_id',
    	'currency_id',
    	'other_data',
    	'status',
    	'reason',
    	
    ];

    public function files(){
        return $this->hasMany('App\File', 'relation_id', 'id')->where('file_type', 'product');
    }
}

