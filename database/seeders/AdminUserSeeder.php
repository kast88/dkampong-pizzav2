<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            [
                'email' => 'admin@dkampong.com'
            ],
            [
                'name' => 'System Admin',
                'password' => Hash::make('admindkampong@123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }
}
