<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Dish",
    title: "Dish",
    description: "Dish model",
    properties: [
        new OA\Property(property: "id", type: "integer", format: "int64"),
        new OA\Property(property: "name", type: "string"),
        new OA\Property(property: "description", type: "string"),
        new OA\Property(property: "image", type: "string"),
        new OA\Property(property: "destination_id", type: "integer", format: "int64"),
        new OA\Property(property: "created_at", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time"),
    ]
)]
class dish extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image', 'destination_id'];

    public function destination()
    {
        return $this->belongsTo(destination::class);
    }

    public function images()
    {
        return $this->morphMany(image::class, 'imageable');
    }
}
