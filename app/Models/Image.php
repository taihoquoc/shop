<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      schema="Image",
 *      title="Image",
 *      description="Image details",
 *      @OA\Property(property="id", type="integer", format="int64", example=1),
 *      @OA\Property(property="filename", type="string", example="product_1696154698.jpg"),
 *      @OA\Property(property="url", type="string", example="http://localhost/storage/product/M2HMAoAVdUYbEbe0HgLnPHpQh1FGPoht2RtBoEZG.jpg"),
 *      @OA\Property(property="created_at", type="string", format="date-time"),
 *      @OA\Property(property="updated_at", type="string", format="date-time"),
 *      @OA\Property(property="deleted_at", type="string", format="date-time"),
 * )
 */
class Image extends Model
{
    use HasFactory;

    protected $table = "images";

    protected $fillable = ['product_id', 'url', 'filename'];

    public function product() {
        return $this->belongsTo('App\Models\Product');
    }
}
