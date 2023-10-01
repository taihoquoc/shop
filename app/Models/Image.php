<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;

    protected $table = "images";

    protected $fillable = ['product_id', 'url', 'filename'];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }
}
