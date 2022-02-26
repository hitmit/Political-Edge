<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "admin",
            "email" => "admin@gmail.com",
            "phone" => "9876543210",
            "password" => Hash::make("password"),
            "is_admin" => 1,
        ]);
    }
}
