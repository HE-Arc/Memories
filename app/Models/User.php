<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Memory;


class User extends Authenticatable implements Searchable
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

    public function memoriesPictures()
    {
        return $this->hasManyThrough(MemoryPicture::class, Memory::class);
    }


    public function memoriesAndPictures()
    {
        return Memory::with('pictures')->where('user_id',$this->id)->latest()->paginate(6);
    }

    // friendship that this user started
    protected function friendsOfThisUser()
    {
        //select * where user_id = me or friend_id = me

        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
		->withPivot('status')
		->wherePivot('status', 'confirmed');
    }

    // friendship that this user was asked for
	protected function thisUserFriendOf()
	{
		return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
		->withPivot('status')
		->wherePivot('status', 'confirmed');
	}

    /**
     * return all friends of the current user
     */
    public function friendsPending(){
        //select * where friend_id is me
        return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
		->withPivot('status')
		->wherePivot('status', 'pending');
    }

    public function getSearchResult(): SearchResult
    {
        $url = route('friends.index', $this->id);
        return new SearchResult($this, $this->name, $url);
    }
}
