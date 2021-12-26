<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class MemoryPicture extends Model
{
    use HasFactory;

    /*
     *get memory's user
    */
    public function memory()
    {
        return $this->belongsTo(Memory::class);
    }

    public function getUrlPicture()
    {
        $userid = auth()->id();
        $idMemory =  $this->memory_id;

        $src = $userid . '/' . $idMemory . '/';
        return Storage::url($src);
    }
}
