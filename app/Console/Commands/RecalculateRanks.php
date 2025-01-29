<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Ranking;
use Illuminate\Support\Facades\DB;

class RecalculateRanks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'leaderboard:recalculate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recalculate user ranks based on activity points';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        DB::table('rankings')->truncate();

        $rankedUsers = User::select('users.id', 'users.name', DB::raw('SUM(activities.points) as total_points'))
            ->leftJoin('activities', 'users.id', '=', 'activities.user_id')
            ->groupBy('users.id', 'users.name')
            ->orderByDesc('total_points')
            ->get();

        $rank = 1;
        $prevPoints = null;
        foreach ($rankedUsers as $index => $user) {
            if ($prevPoints !== null && $user->total_points < $prevPoints) {
                $rank = $index + 1;
            }
            Ranking::create([
                'user_id' => $user->id,
                'total_points' => $user->total_points,
                'rank' => $rank
            ]);
            $prevPoints = $user->total_points;
        }

        $this->info('Leaderboard rankings updated.');
    }
}
