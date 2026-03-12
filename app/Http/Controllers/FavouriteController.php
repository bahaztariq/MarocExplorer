<?php

namespace App\Http\Controllers;

use App\Models\itineraire;
use Illuminate\Http\Request;

class FavouriteController extends Controller
{
    /**
     * Display all favourited itineraires for the authenticated user.
     */
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
