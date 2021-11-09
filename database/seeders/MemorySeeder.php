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
            'name' => Str::random(40),
            'user_id' => 1,
            'description' => Str::random(40),
            'location' => DB::raw('ST_SRID(Point('.$longitude.', '.$latitude.'), 4326)'),
            //'location' => new Point($latitude, $longitude, $srid = 4326)
        ]);
    }
}
