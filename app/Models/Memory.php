<?php

namespace App\Models;

use App\Enums\Publishing;
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
       return $this->belongsTo(User::class);
    }

    /**
     * return all memories pictures of the current memory
     */
    public function pictures(){
        return $this->hasMany(MemoryPicture::class)->orderBy('order');
    }

   public static function publicMemories()
   {
        $userid = auth()->id();

       return Memory::wherePublishing(Publishing::P_PUBLIC)
       ->where('user_id', '!=', $userid)
       ->with('user')
       ->with('pictures')
       ->get();
   }



}
