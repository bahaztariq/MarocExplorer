<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Destination",
    title: "Destination",
    description: "Destination model",
    properties: [
        new OA\Property(property: "id", type: "integer", format: "int64"),
        new OA\Property(property: "name", type: "string"),
        new OA\Property(property: "description", type: "string"),
        new OA\Property(property: "image", type: "string"),
        new OA\Property(property: "itineraire_id", type: "integer", format: "int64"),
        new OA\Property(property: "created_at", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time"),
    ]
)]
class destination extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'image', 'itineraire_id'];

    public function itineraires()
    {
        return $this->belongsTo(itineraire::class);
    }

    public function dishes()
    {
        return $this->hasMany(dish::class);
    }

    public function activities()
    {
        return $this->hasMany(activity::class);
    }

    public function images()
    {
        return $this->morphMany(image::class, 'imageable');
    }
}
