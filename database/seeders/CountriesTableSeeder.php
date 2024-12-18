<?php

namespace Database\Seeders;

use App\Domains\Core\Models\Country;
use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Country::factory()->createMany([
            [
                'name' => "Canada",
            ],
            [
                'name' => "France",
            ]
        ]);
    }
}
