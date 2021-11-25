<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FriendsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('friends')->insert([
            [
                'user_id' => 1,
                'friend_id' => 2,
                'status' => 'confirmed',
            ],
            [
                'user_id' => 2,
                'friend_id' => 3,
                'status' => 'pending',
            ]
        ]);
    }
}
