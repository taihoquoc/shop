<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

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

    public function deleteAllImage() {
        $images = $this->images;
        foreach($images as $image) {
            Storage::delete($image->url);
            $image->delete();
        }
    }

    public function removeAllImage() {
        $images = $this->images;
        foreach($images as $image) {
            $image->product_id = null;
            $image->save();
        }
    }
}
