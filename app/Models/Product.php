<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function brand() {
        return $this->belongsTo('App\Models\Brand');
    }

    public function images() {
        return $this->hasMany('App\Models\Image', 'product_id');
    }
}
