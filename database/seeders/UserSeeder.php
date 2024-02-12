<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends BaseSeeder
{
    public function run(): void
    {
        User::factory(1)->create([
            'name' => 'Demo User',
            'email' => 'admin@filamentphp.com',
        ]);
    }
}
