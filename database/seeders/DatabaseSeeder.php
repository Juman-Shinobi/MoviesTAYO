<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Seat;
use App\Models\Showtime;
use App\Models\Theater;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@moviestayo.test',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Employee User',
            'email' => 'employee@moviestayo.test',
            'password' => Hash::make('password123'),
            'role' => 'employee',
        ]);

        User::create([
            'name' => 'Customer User',
            'email' => 'customer@moviestayo.test',
            'password' => Hash::make('password123'),
            'role' => 'customer',
        ]);

        $movies = collect([
            [
                'title' => 'Avatar: Fire and Ash',
                'genre' => 'Action/Adventure',
                'rating' => 'PG-13',
                'duration' => 195,
                'release_date' => '2025-12-19',
                'description' => 'Jake and Neytiri grapple with grief while the Ash People reshape Pandora.',
                'poster_path' => 'images/posters/avatar movie.jpg',
                'status' => 'now_showing',
            ],
            [
                'title' => 'Anaconda',
                'genre' => 'Comedy',
                'rating' => 'PG-13',
                'duration' => 110,
                'release_date' => '2025-12-01',
                'description' => 'A comedy adventure that will leave you breathless.',
                'poster_path' => 'images/posters/anaconda.jpg',
                'status' => 'now_showing',
            ],
            [
                'title' => 'JJK: Execution',
                'genre' => 'Action/Anime',
                'rating' => 'PG-13',
                'duration' => 128,
                'release_date' => '2025-12-05',
                'description' => 'The next chapter of the sorcery battle arrives.',
                'poster_path' => 'images/posters/JJK Execution.jpg',
                'status' => 'now_showing',
            ],
            [
                'title' => 'Scream',
                'genre' => 'Horror',
                'rating' => 'R',
                'duration' => 102,
                'release_date' => '2025-12-22',
                'description' => 'The mask returns for another chilling night.',
                'poster_path' => 'images/posters/scream.jpeg',
                'status' => 'coming_soon',
            ],
            [
                'title' => 'The Housemaid',
                'genre' => 'Thriller',
                'rating' => 'R',
                'duration' => 115,
                'release_date' => '2025-12-30',
                'description' => 'A dark thriller about secrets and survival.',
                'poster_path' => 'images/posters/housemaid.jpg',
                'status' => 'coming_soon',
            ],
        ])->map(fn ($movie) => Movie::create($movie));

        $theaters = collect([
            ['theater_name' => 'SM Manila', 'location' => 'Manila', 'capacity' => 50],
            ['theater_name' => 'SM Megamall', 'location' => 'Mandaluyong', 'capacity' => 50],
        ])->map(fn ($theater) => Theater::create($theater));

        $theaters->each(function (Theater $theater) {
            $rows = range('A', 'E');
            foreach ($rows as $row) {
                for ($i = 1; $i <= 10; $i++) {
                    Seat::create([
                        'theater_id' => $theater->id,
                        'seat_number' => $row.$i,
                        'seat_status' => 'available',
                    ]);
                }
            }
        });

        $showDates = collect([
            now()->addDays(1)->toDateString(),
            now()->addDays(2)->toDateString(),
            now()->addDays(3)->toDateString(),
        ]);

        foreach ($movies->where('status', 'now_showing') as $movie) {
            foreach ($theaters as $theater) {
                foreach ($showDates as $date) {
                    Showtime::create([
                        'movie_id' => $movie->id,
                        'theater_id' => $theater->id,
                        'show_date' => $date,
                        'show_time' => collect(['13:00', '16:00', '19:00'])->random(),
                        'available_seats' => $theater->capacity,
                    ]);
                }
            }
        }
    }
}
