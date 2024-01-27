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
        User::insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'role' => 'Admin',
            'password' => bcrypt('admin123'),
        ]);
        User::insert([
            'name' => 'Referee',
            'email' => 'referee@gmail.com',
            'role' => 'Referee',
            'password' => bcrypt('admin123'),
        ]);
    }
}
