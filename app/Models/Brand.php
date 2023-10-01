<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @OA\Schema(
 *      schema="Brand",
 *      title="Brand",
 *      description="Brand details",
 *      @OA\Property(property="id", type="integer", format="int64", example=1),
 *      @OA\Property(property="name", type="string", example="Gucci"),
 *      @OA\Property(property="created_at", type="string", format="date-time"),
 *      @OA\Property(property="updated_at", type="string", format="date-time"),
 *      @OA\Property(property="deleted_at", type="string", format="date-time"),
 * )
 */
class Brand extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = "brands";

    protected $fillable = ['name'];

}
