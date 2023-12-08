<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Badge;
use App\Models\User;
use Illuminate\Http\Request;

class AchievementsController extends Controller
{
    public function index(User $user)
    {
        $achievements = $user->achievements()->get();
        $current_badge = $user->current_badge;
        $next_achievement = array(
            $this->nextLessonAchievement($user),
            $this->nextCommentAchievement($user),
        );
        $next_badge = $this->nextBadge($user);
        if($next_badge){

            $remaining_to_unlock_next_badge = $next_badge->no_required_of_achievement - $user->achievements()->count();
        }else{
            $remaining_to_unlock_next_badge =null;
        }





        return response()->json([
            'unlocked_achievements' => $achievements,
            'next_available_achievements' =>$next_achievement,
            'current_badge' => $current_badge,
            'next_badge' => $next_badge,
            'remaining_to_unlock_next_badge' => $remaining_to_unlock_next_badge
        ]);
    }




    public function nextBadge(User $user){

        $badge = Badge::where("name",$user->current_badge)->first();

        if($badge){
            $next_badge = Badge::where("id",">", $badge->id)->first();
            return $next_badge;
        }
    }

    public function nextLessonAchievement(User $user){

        $latest_lesson_achievement = $user->achievements()->where("type","lesson")->latest()->first();
        if($latest_lesson_achievement){
            $next_lesson_achievement = Achievement::where("id",">", $latest_lesson_achievement->id)->where("type","lesson")->first();

            if($next_lesson_achievement){
                return $next_lesson_achievement;
            }else{
                return "No Next Lesson Achievement";
            }
        }else{
            return "No Next Lesson Achievement";
        }
    }



    public function nextCommentAchievement(User $user){

        $latest_comment_achievement = $user->achievements()->where("type","comment")->latest()->first();
        if($latest_comment_achievement){
            $next_comment_achievement = Achievement::where("id",">", $latest_comment_achievement->id)->where("type","comment")->first();

            if($next_comment_achievement){
                return $next_comment_achievement;
            }else{
                return "No Next Comment Achievement";
            }
        }else{
            return "No Next Comment Achievement";
        }
    }
}
