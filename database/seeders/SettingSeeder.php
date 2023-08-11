<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
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
                'name' => 'site_logo',
                'value' => 'site_logo'
            ],
            [
                'name' => 'stripe_public_key',
                'value' => 'stripe_public_key'
            ],
            [
                'name' => 'stripe_secret_key',
                'value' => 'stripe_secret_key'
            ],
            [
                'name' => 'stripe_mode',
                'value' => 'test'
            ]
        ];

        foreach($data as $row) {
            Setting::create($row);
        }
    }
}
