<?php






namespace App\QueryBuilder;

use App\Models\destination;
use App\Models\activity;
use App\Models\dish;
use App\Models\itineraire;
use Illuminate\Support\Facades\DB;



class ItineraireQueryBuilder
{
    public function getItinerairesWithDetails()
    {
        return DB::table('itineraires')
            ->join('destinations', 'itineraires.destination_id', '=', 'destinations.id')
            ->join('activities', 'destinations.id', '=', 'activities.destination_id')
            ->join('dishes', 'destinations.id', '=', 'dishes.destination_id')
            ->select('itineraires.*', 'destinations.name as destination_name', 'activities.name as activity_name', 'dishes.name as dish_name')
            ->get();
    }

    public function getItineraireById($id)
    {
        return DB::table('itineraires')
            ->join('destinations', 'itineraires.destination_id', '=', 'destinations.id')
            ->join('activities', 'destinations.id', '=', 'activities.destination_id')
            ->join('dishes', 'destinations.id', '=', 'dishes.destination_id')
            ->select('itineraires.*', 'destinations.name as destination_name', 'activities.name as activity_name', 'dishes.name as dish_name')
            ->where('itineraires.id', $id)
            ->first();
    }

    public function searchItineraires($query)
    {
        return DB::table('itineraires')
            ->join('destinations', 'itineraires.destination_id', '=', 'destinations.id')
            ->join('activities', 'destinations.id', '=', 'activities.destination_id')
            ->join('dishes', 'destinations.id', '=', 'dishes.destination_id')
            ->select('itineraires.*', 'destinations.name as destination_name', 'activities.name as activity_name', 'dishes.name as dish_name')
            ->where('itineraires.title', 'like', "%$query%")
            ->orWhere('destinations.name', 'like', "%$query%")
            ->orWhere('activities.name', 'like', "%$query%")
            ->orWhere('dishes.name', 'like', "%$query%")
            ->get();
    }

    public function getItinerairesByCategory($query)
    {
        return DB::table('itineraires')
            ->join('destinations', 'itineraires.destination_id', '=', 'destinations.id')
            ->join('activities', 'destinations.id', '=', 'activities.destination_id')
            ->join('dishes', 'destinations.id', '=', 'dishes.destination_id')
            ->select('itineraires.*', 'destinations.name as destination_name', 'activities.name as activity_name', 'dishes.name as dish_name')
            ->where('itineraires.category', 'like', "%$query%")
            ->orWhere('itineraires.duration', 'like', "%$query%")
            ->get();
    }

    public function TotalByCategoryAndDuration($category, $duration)
    {
        return DB::table('itineraires')
            ->select('category', 'duration', DB::raw('count(*) as total'))
            ->where('category', 'like', "%$category%")
            ->where('duration', 'like', "%$duration%")
            ->groupBy('category', 'duration') 
            ->get();
    }

    public function MostPopularItineraires()
    {
        return DB::table('itineraires')
            ->leftJoin('favourites', 'itineraires.id', '=', 'favourites.itinerary_id')
            ->select('itineraires.*', DB::raw('COUNT(favourites.id) as total_favourites'))
            ->groupBy('itineraires.id')
            ->orderByDesc('total_favourites')
            ->get();
    }

}