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
        User::create([
            'first_name' => 'user',
            'last_name' => 'user',
            'personal_code' => '0123456789',
            'email' => 'user@example.com',
            'phone' => '0912345678',
            'password' => bcrypt(123456),
        ]);
    }
}
