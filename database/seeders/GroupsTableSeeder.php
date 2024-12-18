<?php

namespace Database\Seeders;

use App\Domains\Community\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::query()
            ->where('email', '=', 'admin@admin.com')
            ->firstOrFail();

        Group::factory()
            ->for($user)
            ->count(5)
            ->create();
    }
}
