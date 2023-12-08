<?php

namespace App\Http\Controllers;

use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        $achievements = $user->achievements()->get();

        $current_badge = $user->current_badge;
        $badge = Badge::where("name",$current_badge)->first();
        $next_badge = Badge::where("id",">", $badge->id)->first();
        $remaing_to_unlock_next_badge = $next_badge->no_required_of_achievement - $user->achievements()->count();


        return response()->json([
            'unlocked_achievements' => $achievements,
            'next_available_achievements' => [],
            'current_badge' => $current_badge,
            'next_badge' => $next_badge,
            'remaing_to_unlock_next_badge' => $remaing_to_unlock_next_badge
        ]);
    }
}
