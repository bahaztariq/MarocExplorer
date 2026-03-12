<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
