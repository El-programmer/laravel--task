<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'email' => 'admin@admin.com',
                'name' => 'Admin',
                'role' => 'Super-Admin',
                'password' => Hash::make('123456')
            ],[
                'email' => 'ahmed@admin.com',
                'name' => 'Ahmed',
                'role' => 'member',
                'password' => Hash::make('123456')
            ],
        ];
        User::insert($users);
    }
}
