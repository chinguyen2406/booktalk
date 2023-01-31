<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@test.com',
            'password' => Hash::make('secret'),
            'role' => 2,
            'gender' => 'male',
            'slug' => 'admin',
            'pic' => 'nha_gia_kim.jpg'

        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@test.com',
            'password' => Hash::make('secret'),
            'role' => 1,
            'gender' => 'male',
            'slug' => 'user',
            'pic' => 'nha_gia_kim.jpg'
        ]);
    }
}
