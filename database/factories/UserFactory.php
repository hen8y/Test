<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Achievement;
use App\Models\Badge;
use App\Models\Lesson;
use Hash;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make(Str::random(10)), // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function configure(){

       return $this->afterCreating(function (User $user) {
            $lesson = Lesson::inRandomOrder()->first();
            $user->lessons()->attach($lesson);

            $badge = Badge::inRandomOrder()->first();
            $user->badges()->attach($badge);

            $achievement = Achievement::inRandomOrder()->first();
            $user->achievements()->attach($achievement);
       });
    }
}

