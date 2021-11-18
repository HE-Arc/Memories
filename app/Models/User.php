<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Memory;


class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * return all memories of the current user
     */
    public function memories(){
        return $this->hasMany(Memory::class);
    }

    /**
     * return all friends of the current user
     */
    public function friendsConfirmed(){
        return $this->belongsToMany(User::class, 'friends', 'user_id1', 'user_id2')
		->withPivot('status')
		->wherePivot('status', 'confirmed');
    }

        /**
     * return all friends of the current user
     */
    public function friendsPending(){
        return $this->belongsToMany(User::class, 'friends', 'user_id1', 'user_id2')
		->withPivot('status')
		->wherePivot('status', 'pending');
    }
}
