<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Achievement;
use App\Models\Lesson;
use App\Listeners\CheckLessonAchievement;
use App\Events\LessonWatched;
use App\Events\AchievementUnlocked;
use Illuminate\Support\Facades\Event;

class CheckLessonAchievementTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_check_lesson_achievement(): void
    {

        $user = User::factory()->create();
        $achievement = Achievement::factory()->create([
            "name"=>"First Lesson Watched",
            'no_required_of_activity' => 1,
            "type"=>"lesson"
        ]);
        $lesson = Lesson::factory()->create();

        Event::fake();

        $event = new LessonWatched($lesson, $user);
        $listener = new CheckLessonAchievement();
        $listener->handle($event);

        $this->assertDatabaseHas('lesson_user', [
            'user_id' => $user->id,
            'lesson_id' => $lesson->id,
            'watched' => true,
        ]);

        Event::assertDispatched(AchievementUnlocked::class);

    }
}
