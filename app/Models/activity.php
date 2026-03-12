<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class activity extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'destination_id'];

    public function destination()
    {
        return $this->belongsTo(destination::class);
    }
}
