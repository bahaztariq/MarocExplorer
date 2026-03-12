<?php



namespace App\QueryBuilder;

use App\Models\User;
use Illuminate\Support\Facades\DB;



class UserQueryBuilder
{
    public function totalUsersPerMonth()
    {
        return DB::table('users')
            ->select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as total'))
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
    }
}