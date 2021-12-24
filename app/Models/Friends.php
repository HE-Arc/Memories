<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
    use HasFactory;

    public static function isFriend($id,$other_id){
        return Friends::where([
                ['user_id', '=', $id],
                ['friend_id', '=', $other_id]])
            ->orWhere([
                ['friend_id', '=', $id],
                ['user_id', '=', $other_id]])->count();
    }
}
