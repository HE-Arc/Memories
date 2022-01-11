<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

/**
 * MemoryPicture
 * Model which represent a picture of a memory
 */
class MemoryPicture extends Model
{
    use HasFactory;

    /*
     *get memory which is associate to the picture
    */
    public function memory()
    {
        return $this->belongsTo(Memory::class);
    }

    /*
    * return the path of this picture
    */
    public function getUrlPicture()
    {
        $userid = auth()->id();
        $idMemory =  $this->memory_id;

        $src = $userid . '/' . $idMemory . '/';
        return Storage::url($src);
    }
}
