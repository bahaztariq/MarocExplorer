<?php

namespace App\Http\Controllers;

use App\Models\dish;
use Illuminate\Http\Request;

class DishController extends Controller
{
    /**
     * Display a listing of all dishes.
     */
    public function index()
    {
        $dishes = dish::with('destination')->get();

        return response()->json([
            'message' => 'Dishes fetched successfully.',
            'dishes' => $dishes,
        ], 200);
    }

    /**
     * Display a specific dish.
     */
    public function show($id)
    {
        $dish = dish::with('destination')->find($id);

        if (!$dish) {
            return response()->json([
                'message' => 'Dish not found.',
            ], 404);
        }

        return response()->json([
            'message' => 'Dish fetched successfully.',
            'dish' => $dish,
        ], 200);
    }
}
