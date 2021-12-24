<?php

namespace App\Http\Controllers;

use App\Enums\Status;
use App\Models\Friends;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Searchable\Search;

class FriendsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $id = auth()->id();
        $user = User::find($id);
        $friendsOfThisUser = $user->friendsOfThisUser;
        $thisUserFriendOf = $user->thisUserFriendOf;
        $friendsConfirmed = $friendsOfThisUser->merge($thisUserFriendOf);
        $friendsPending = $user->friendsPending;
        return inertia('Friends/Index',compact('friendsConfirmed', 'friendsPending'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
        ]);

        $userFriend = User::where('name',$request->name)->first();
        $id = auth()->id();
        $user = User::find($id);

        if($user == $userFriend)
        {
            return redirect()->route('friends.index')
                ->with('danger',"You can't to add yourself");
        }
        elseif(is_null($userFriend))
        {
            return redirect()->route('friends.index')->with('danger',"User doesn't exist");
        }
        else
        {
            $friendsShip = Friends::isFriend($userFriend->id,$user->id);
            if(empty($friendsShip))
            {
                $friend = new Friends();
                $friend->friend_id = $userFriend->id;
                $friend->user_id = auth()->id();
                $friend->status = Status::PENDING;
                $friend->save();

                return redirect()->route('friends.index')->with('success','Request friendship successfully');
            }

            return redirect()->route('friends.index')->with('warning',"Request friendship has been already send");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Friends  $friends
     * @return \Illuminate\Http\Response
     */
    public function show(Friends $friends)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Friends  $friends
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Friends  $friends
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $user = Friends::where("friend_id",auth()->id())->where("user_id",$id)->firstOrFail();
        $user->status = Status::CONFIRMED;

        $user->save();

        return redirect()->route('friends.index')
                        ->with('success','Friend accepted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Friends  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Friends::where("friend_id",$id)->where("user_id",auth()->id())->delete();

        return redirect()->route('friends.index')
                        ->with('success','Friends deleted successfully');
    }

    /**
     * Get all user contains name
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $results = (new Search())
            ->registerModel(User::class, ['name'])
            ->search($request->input('name'));

        return response()->json($results);
    }
}
