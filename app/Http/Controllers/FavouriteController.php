<?php

namespace App\Http\Controllers;

use App\Models\itineraire;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

class FavouriteController extends Controller
{
    /**
     * Display all favourited itineraires for the authenticated user.
     */
    #[OA\Get(
        path: "/api/v1/favourites",
        summary: "Display favourited itineraires",
        description: "Returns a list of all itineraires favourited by the authenticated user.",
        tags: ["Favourites"],
        security: [['sanctum' => []]],
        responses: [
            new OA\Response(response: 200, description: "Favourites fetched successfully.")
        ]
    )]
    public function index()
    {
        $favourites = auth()->user()->favouriteItineraires()->get();

        return response()->json([
            'favourites' => $favourites,
        ]);
    }

    /**
     * Toggle favourite for a given itineraire (add if not exists, remove if exists).
     */
    #[OA\Post(
        path: "/api/v1/favourites/{itineraire}",
        summary: "Toggle favourite",
        description: "Adds or removes an itineraire from the authenticated user's favourites.",
        tags: ["Favourites"],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: "itineraire", in: "path", required: true, description: "The ID of the itineraire", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Favourited state toggled successfully.")
        ]
    )]
    public function toggle(itineraire $itineraire)
    {
        $result = auth()->user()->favouriteItineraires()->toggle($itineraire->id);

        $isFavourited = count($result['attached']) > 0;

        return response()->json([
            'message'      => $isFavourited ? 'Added to favourites.' : 'Removed from favourites.',
            'is_favourited' => $isFavourited,
        ]);
    }

    /**
     * Check if an itineraire is favourited by the authenticated user.
     */
    #[OA\Get(
        path: "/api/v1/favourites/{itineraire}/check",
        summary: "Check favourite state",
        description: "Returns whether a specific itineraire is favourited by the authenticated user.",
        tags: ["Favourites"],
        security: [['sanctum' => []]],
        parameters: [
            new OA\Parameter(name: "itineraire", in: "path", required: true, description: "The ID of the itineraire", schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Favourite state checked successfully.")
        ]
    )]
    public function check(itineraire $itineraire)
    {
        $isFavourited = auth()->user()
            ->favouriteItineraires()
            ->where('itineraires.id', $itineraire->id)
            ->exists();

        return response()->json([
            'is_favourited' => $isFavourited,
        ]);
    }
}
