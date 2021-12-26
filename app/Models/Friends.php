<?php

namespace App\Models;

use App\Enums\Status;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Friends extends Model
{
    use HasFactory;

    /*
    * check if a user is a friendship exist
    */
    public static function isFriend($id,$other_id){
        return Friends::where([
                ['user_id', '=', $id],
                ['friend_id', '=', $other_id]])
            ->orWhere([
                ['friend_id', '=', $id],
                ['user_id', '=', $other_id]])->count();
    }

    /*
    * check how many request the current has to accept
    */
    public static function newRequest(){
        return Friends::where([
                ['friend_id', '=', auth()->id()],
                ['status', '=', Status::PENDING]])->count();
    }
}
