<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@admin.ch',
                'password' => Hash::make('admin$00'),
            ],
            [
                'name' => 'ilyas',
                'email' => 'ilyas@admin.ch',
                'password' => Hash::make('admin$00'),
            ],
            [
                'name' => 'david',
                'email' => 'david@admin.ch',
                'password' => Hash::make('admin$00'),
            ]
        ]);
    }
}
