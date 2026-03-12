<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
