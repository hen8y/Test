<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Achievement>
 */
class AchievementFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $type = $this->faker->randomElement(["comment","lesson"]);
        if ($type === "comment") {
            $no_required_of_activity = $this->faker->unique()->randomElement([1,3,5,10,20]);
        }else{
            $no_required_of_activity = $this->faker->unique()->randomElement([1,5,10,25,50]);
        }
        return [
            "name"=>fake()->name(),
            "type"=>$type,
            "no_required_of_activity"=>$no_required_of_activity,
        ];

    }
}
