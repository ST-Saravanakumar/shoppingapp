<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'name' => 'admin',
                'first_name' => 'admin',
                'last_name' => 'user',
                'email' => 'adminuser@gmail.com',
                'password' => '$2y$10$ntIUeeV3IkLrNu5c4nKaEuKTwogsX6.xc0TV3KdxcYWltWCrGqcCK',
                'role' => 'admin'
            ]
        ];

        foreach($data as $row) {
            User::create($row);
        }

    }
}
