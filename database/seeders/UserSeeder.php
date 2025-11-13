<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name' => 'PT Nusantara Tech',
            'email' => 'employer@example.com',
            'password' => bcrypt('password'),
            'role' => 'employer',
        ]);

        User::create([
            'name' => 'Endros Freelancer',
            'email' => 'freelancer@example.com',
            'password' => bcrypt('password'),
            'role' => 'freelancer',
        ]);


        User::factory(5)->create();

    }
}
