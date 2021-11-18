<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Grimzy\LaravelMysqlSpatial\Types\Point; //composer require grimzy/laravel-mysql-spatial:^4.0


class MemorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $longitude = 20;
        $latitude = 40;

        DB::table('memories')->insert([
            [
                'name' => "Voyage au bois du petit château",
                'user_id' => 1,
                'description' => "Une magnifique description",
                'location' => DB::raw('ST_SRID(Point('.$longitude.', '.$latitude.'), 4326)'),
            ],
            [
                'name' => "Photos de la campagne",
                'user_id' => 2,
                'description' => "Une super belle description d'un memory absolument magnifique",
                'location' => DB::raw('ST_SRID(Point('.$longitude.', '.$latitude.'), 4326)'),
            ],
        ]);
    }
}
