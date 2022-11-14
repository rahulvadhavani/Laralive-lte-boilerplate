<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'first_name' => 'Mr.',
            'last_name' => 'Admin',
            'role' => 1,
            'email' => env('ADMIN_EMAIL')?? 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
    }
}
