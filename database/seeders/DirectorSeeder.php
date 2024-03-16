<?php

namespace Database\Seeders;

use App\Models\Director;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DirectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Director::factory()
            ->count(25)
            ->hasMovies(10)
            ->hasFilms(10)
            ->create();

        Director::factory()
            ->count(100)
            ->hasMovies(5)
            ->hasFilms(5)
            ->create();

        Director::factory()
            ->count(20)
            ->hasMovies(3)
            ->hasFilms(20)
            ->create();

        Director::factory()
            ->count(5)
            ->create();

    }
}
