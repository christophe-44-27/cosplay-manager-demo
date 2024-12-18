<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => "Jaina Portevaillant",
            'email' => 'admin@admin.com',
            'email_verified_at' => Carbon::now(),
        ]);

        User::factory()->create([
            'name' => "Albus Dumbledore",
            'email' => 'admin@admin2.com',
            'email_verified_at' => Carbon::now(),
        ]);

        $this->call([
            CategoriesTableSeeder::class,
            CountriesTableSeeder::class,
            ProjectTableSeeder::class,
            ProjectElementTableSeeder::class,
            GroupsTableSeeder::class
        ]);
    }
}
