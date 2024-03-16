<?php

namespace Database\Factories;

use App\Models\Director;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->sentence(6),
            'poster_image' => $this->faker->text(5),
            'rating' => $this->faker->numberBetween(1, 10),
            'release_date' => $this->faker->dateTimeThisDecade(),
            'director_id' => Director::factory(),
        ];
    }
}
