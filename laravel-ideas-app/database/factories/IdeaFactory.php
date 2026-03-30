<?php

namespace Database\Factories;

use App\IdeaStatus;
use App\Models\Idea;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Idea>
 */
class IdeaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(3),
            'links' => fake()->url(),
            'status' => fake()->randomElement([IdeaStatus::COMPLETED, IdeaStatus::IN_PROGRESS, IdeaStatus::PENDING]),
        ];
    }
}
