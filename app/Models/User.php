<?php

namespace App\Models;

use App\Enums\Publishing;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Memory;


/**
 * User
 * Model which represent a user
 * implement searchable to find user by name in the friends view
 */
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

    /**
     * return all memories pictures of the current user
     */
    public function memoriesPictures()
    {
        return $this->hasManyThrough(MemoryPicture::class, Memory::class);
    }

    /**
     * return all memories with pictures of the current user
     */
    public function memoriesAndPictures()
    {
        return Memory::with('pictures')->where('user_id',$this->id)->latest()->paginate(6);
    }

    /*
    * return all friendship that this user started
    */
    public function friendsOfThisUser()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
		->withPivot('status')
		->wherePivot('status', 'confirmed');
    }

    /*
    * return all friendship that this user was asked for
    */
	public function thisUserFriendOf()
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

    /*
    * return all users containing name
    */
    public function getSearchResult(): SearchResult
    {
        $url = route('friends.index', $this->id);
        return new SearchResult($this, $this->name, $url);
    }

    /*
    * return all memories and picture which are friends only
    */
    public function memoriesAndPicturesProtected()
    {
        return $this->hasMany(Memory::class)->wherePublishing(Publishing::P_FRIENDS)->with('pictures');
    }

    /*
    * return all memories of my friends (this user has been invited by the friend)
    */
    public function friendsMemoriesOfThisUser()
    {
       return $this
        ->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
		->withPivot('status')
		->wherePivot('status', 'confirmed')
        ->with('memoriesAndPicturesProtected');


    }

    /*
    * return all memories of my friends (this user has initiate the friendship)
    */
    public function memoriesOfthisUserFriendOf()
	{
		return $this->belongsToMany(User::class, 'friends', 'friend_id', 'user_id')
		->withPivot('status')
		->wherePivot('status', 'confirmed')
        ->with('memoriesAndPicturesProtected');

	}
}
