<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Ranking;

use Carbon\Carbon;

class LeaderboardController extends Controller
{
    //
     public function index(Request $request)
    {
        $userId = $request->input('user_id');

        $filter = $request->input('filter', 'day'); 

        $query = Ranking::with('user');

        $query->whereHas('user.activities', function ($q) use ($filter) {
            if ($filter == 'day') {
                $q->whereDate('performed_at', Carbon::today());
            } elseif ($filter == 'month') {
                $q->whereMonth('performed_at',  Carbon::now()->month);
            } elseif ($filter == 'year') {
                $q->whereYear('performed_at', Carbon::now()->year);
            }
        });

        $rankings = $query->orderBy('rank')->get();

        if ($userId) {
            $filteredUser = $rankings->where('user_id', $userId)->first();

            if ($filteredUser) {
                $rankings = $rankings->reject(fn($item) => $item->user_id == $userId);
                $rankings->prepend($filteredUser);
            }
        }


        return view('leaderboard.index',compact('rankings', 'userId', 'filter'));
    }
}
