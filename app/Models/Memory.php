<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Grimzy\LaravelMysqlSpatial\Eloquent\SpatialTrait;


/**
 * @property \Grimzy\LaravelMysqlSpatial\Types\Point   $location
 */
class Memory extends Model
{
    use HasFactory;
    use SpatialTrait;

    protected $spatialFields = [
        'location'
    ];

    /*
     *get memory's user
    */
    public function user() {
        $this->belongsTo(User::class);
    }
}
