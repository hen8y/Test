<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Achievement;
use App\Models\Comment;
use App\Listeners\CheckCommentAchievement;
use App\Events\CommentWritten;
use App\Events\AchievementUnlocked;
use Illuminate\Support\Facades\Event;

class CheckCommentAchievementTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_check_comment_achievement(): void
    {

        $user = User::factory()->create();
        $achievement = Achievement::factory()->create([
            "name"=>"First Comment Written",
            'no_required_of_activity' => 1,
            "type"=>"comment"
        ]);
        $comment = Comment::factory()->create(['user_id' => $user->id]);

        Event::fake();

        $event = new CommentWritten($comment);
        $listener = new CheckCommentAchievement();
        $listener->handle($event);

        Event::assertDispatched(AchievementUnlocked::class);

    }
}
