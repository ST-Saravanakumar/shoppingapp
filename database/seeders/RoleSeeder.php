<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
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
                'guard_name' => 'admin'
            ],
            [
                'name' => 'user',
                'guard_name' => 'web'
            ],
            [
                'name' => 'vendor',
                'guard_name' => 'web'
            ]
        ];

        foreach($data as $row) {
            Role::create($row);
        }
    }
}
