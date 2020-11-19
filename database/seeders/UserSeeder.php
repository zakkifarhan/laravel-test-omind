<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return User::create([
            'name' => 'zakkifarhan',
            'email' => 'farhan.zakki@gmail.com',
            'password' => 'admin123',
            'role' => '1',
        ]);
    }
}
