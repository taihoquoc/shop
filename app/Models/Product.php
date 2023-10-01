<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

/**
 * @OA\Schema(
 *      schema="Product",
 *      title="Product",
 *      description="Product details",
 *      @OA\Property(property="id", type="integer", format="int64", example=1),
 *      @OA\Property(property="title", type="string", example="Product Title"),
 *      @OA\Property(property="description", type="string", example="This is a sample product."),
 *      @OA\Property(property="price", type="number", format="float", example=19.99),
 *      @OA\Property(property="promo_price", type="number", format="float", example=10.99),
 *      @OA\Property(property="brand", ref="#/components/schemas/Brand"),
 *      @OA\Property(property="images", type="array", @OA\Items(ref="#/components/schemas/Image")),
 *      @OA\Property(property="created_at", type="string", format="date-time"),
 *      @OA\Property(property="updated_at", type="string", format="date-time"),
 *      @OA\Property(property="deleted_at", type="string", format="date-time"),
 * )
 */
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
