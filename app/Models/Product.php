<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "products";

    protected $fillable = ['title', 'description', 'brand_id', 'price', 'promo_price', 'user_id'];

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
