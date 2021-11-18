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
                'user_id1' => 3,
                'user_id2' => 4,
                'status' => 'confirmed',
            ],
            [
                'user_id1' => 4,
                'user_id2' => 5,
                'status' => 'pending',
            ]
        ]);
    }
}
