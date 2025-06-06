<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => fake()->randomElement([1, 2, 3]),
            'title' => fake()->sentence(10),
            'desc' => fake()->paragraph(3),
            'email' => fake()->safeEmail(),
            'link' => fake()->url(),
            'tags' => fake()->randomElement(['Laravel', 'Vue', 'React', 'PHP', 'JavaScript', 'CSS', 'HTML', 'Tailwind CSS', 'Bootstrap', 'Inertia.js']),
            'is_approved' => 1,
        ];
    }
}
