<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin1@email.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'status' => 'verified',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Vendor User',
                'email' => 'vendor@email.com',
                'password' => Hash::make('12345678'),
                'role' => 'vendor',
                'status' => 'normal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Affiliate User',
                'email' => 'affiliate@email.com',
                'password' => Hash::make('12345678'),
                'role' => 'affiliator',
                'status' => 'normal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Normal User',
                'email' => 'normal@email.com',
                'password' => Hash::make('12345678'),
                'role' => 'user',
                'status' => 'normal',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
