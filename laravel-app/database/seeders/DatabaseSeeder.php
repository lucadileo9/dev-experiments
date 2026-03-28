<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Idea;


class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $me = User::factory()->create([
            'name' => 'luca',
            'email' => 'luca@luca.com',
            'password' => bcrypt('luca'),
        ]);

        Idea::factory(5)->create([
            'user_id' => $me->id
        ]);

        User::factory(10)->hasIdeas(3)->create();
    }
}
