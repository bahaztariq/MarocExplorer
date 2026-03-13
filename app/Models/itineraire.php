<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Itineraire",
    title: "Itineraire",
    description: "Itineraire model",
    properties: [
        new OA\Property(property: "id", type: "integer", format: "int64"),
        new OA\Property(property: "title", type: "string"),
        new OA\Property(property: "category", type: "string"),
        new OA\Property(property: "duration", type: "string"),
        new OA\Property(property: "image", type: "string"),
        new OA\Property(property: "user_id", type: "integer", format: "int64"),
        new OA\Property(property: "created_at", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time"),
    ]
)]
class itineraire extends Model
{
    /** @use HasFactory<\Database\Factories\ItineraireFactory> */
    use HasFactory;

    protected $fillable = ['title', 'category', 'duration', 'image', 'user_id'];



    public function destination()
    {
        return $this->hasMany(destination::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favourites', 'itinerary_id', 'user_id');
    }
}
