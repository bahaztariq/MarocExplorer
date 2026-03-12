<?php

namespace App\Http\Controllers;

use App\Models\itineraire;
use Illuminate\Http\Request;

class ItineraireController extends Controller
{
    /**
     * Display a listing of all itineraires.
     */
    public function index()
    {
        $itineraires = itineraire::with([
            'destination.activities',
            'destination.dishes',
        ])->get();

        return response()->json([
            'message' => 'Itineraires fetched successfully.',
            'itineraires' => $itineraires,
        ], 200);
    }

    /**
     * Store a newly created itineraire.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'    => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'image'    => 'required|string|max:255',
        ]);

        $validatedData['user_id'] = $request->user()->id;

        $itineraire = itineraire::create($validatedData);

        return response()->json([
            'message'    => 'Itineraire created successfully.',
            'itineraire' => $itineraire,
        ], 201);
    }

    /**
     * Display a specific itineraire.
     */
    public function show($id)
    {
        $itineraire = itineraire::with([
            'destination.activities',
            'destination.dishes',
        ])->find($id);

        if (!$itineraire) {
            return response()->json([
                'message' => 'Itineraire not found.',
            ], 404);
        }

        return response()->json([
            'message'    => 'Itineraire fetched successfully.',
            'itineraire' => $itineraire,
        ], 200);
    }

    /**
     * Update the specified itineraire.
     */
    public function update(Request $request, $id)
    {
        $itineraire = itineraire::find($id);

        if (!$itineraire) {
            return response()->json([
                'message' => 'Itineraire not found.',
            ], 404);
        }

        if ($itineraire->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        $validatedData = $request->validate([
            'title'    => 'sometimes|string|max:255',
            'category' => 'sometimes|string|max:255',
            'duration' => 'sometimes|string|max:255',
            'image'    => 'sometimes|string|max:255',
        ]);

        $itineraire->update($validatedData);

        return response()->json([
            'message'    => 'Itineraire updated successfully.',
            'itineraire' => $itineraire,
        ], 200);
    }

    /**
     * Remove the specified itineraire.
     */
    public function destroy(Request $request, $id)
    {
        $itineraire = itineraire::find($id);

        if (!$itineraire) {
            return response()->json([
                'message' => 'Itineraire not found.',
            ], 404);
        }

        if ($itineraire->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'Unauthorized.',
            ], 403);
        }

        $itineraire->delete();

        return response()->json([
            'message' => 'Itineraire deleted successfully.',
        ], 200);
    }

    /**
     * Search itineraires by title or category.
     */
    public function search($query)
    {
        $itineraires = itineraire::where('title', 'like', "%$query%")
            ->orWhere('category', 'like', "%$query%")
            ->orwhere('duration', 'like', "%$query%")
            ->with([
                'destination.activities',
                'destination.dishes',
            ])->get();

        return response()->json([
            'message' => 'Itineraires found.',
            'itineraires' => $itineraires,
        ], 200);
    }
}
