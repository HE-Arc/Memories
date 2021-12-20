<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemoryPicture extends Model
{
    use HasFactory;

    /*
     *get memory's user
    */
    public function memory() {
        $this->belongsTo(Memory::class);
    }
}
