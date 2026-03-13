<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Activity",
    title: "Activity",
    description: "Activity model",
    properties: [
        new OA\Property(property: "id", type: "integer", format: "int64"),
        new OA\Property(property: "nom", type: "string"),
        new OA\Property(property: "destination_id", type: "integer", format: "int64"),
        new OA\Property(property: "created_at", type: "string", format: "date-time"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time"),
    ]
)]
class activity extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'destination_id'];

    public function destination()
    {
        return $this->belongsTo(destination::class);
    }
}
