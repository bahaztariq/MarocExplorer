<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class itineraire extends Model
{
    /** @use HasFactory<\Database\Factories\ItineraireFactory> */
    use HasFactory;

    protected $fillable = ['title', 'category', 'duration', 'image', 'user_id'];



    public function destination()
    {
        return $this->hasMany(Destination::class);
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
