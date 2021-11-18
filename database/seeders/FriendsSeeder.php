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
                'user_id1' => 1,
                'user_id2' => 2,
                'status' => 'confirmed',
            ],
            [
                'user_id1' => 2,
                'user_id2' => 3,
                'status' => 'pending',
            ]
        ]);
    }
}
