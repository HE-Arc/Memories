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
        //retrieve the current user
        $id = auth()->id();
        $user = User::find($id);

        //get all friends of this user
        $friendsOfThisUser = $user->friendsOfThisUser;
        $thisUserFriendOf = $user->thisUserFriendOf;
        $friendsConfirmed = $friendsOfThisUser->merge($thisUserFriendOf);

        //get asking friends request
        $friendsPending = $user->friendsPending;

        return inertia('Friends/Index',compact('friendsConfirmed', 'friendsPending'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //check if the request is valid
        $request->validate([
            'name' => 'required',
        ]);

        //find the user
        $userFriend = User::where('name',$request->name)->first();

        //get the current user
        $id = auth()->id();
        $user = User::find($id);

        //check if the friendship is possible

        //cannot be friends with yourself
        if($user == $userFriend)
        {
            return redirect()->route('friends.index')
                ->with('danger',"You can't to add yourself");
        }
        //friends doesn't exist
        elseif(is_null($userFriend))
        {
            return redirect()->route('friends.index')->with('danger',"User doesn't exist");
        }
        else
        {
            //check if we are already friends or if a request is pending
            $friendsShip = Friends::isFriend($userFriend->id,$user->id);

            //if we're not friends
            if(empty($friendsShip))
            {
                //create a new request to be friend
                $friend = new Friends();
                $friend->friend_id = $userFriend->id;
                $friend->user_id = auth()->id();
                $friend->status = Status::PENDING;
                $friend->save();

                return redirect()->route('friends.index')->with('success','Request friendship successfully');
            }

            //already friends or pending firendship
            return redirect()->route('friends.index')->with('warning',"Request friendship has been already send");
        }
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
        //check if the friendship exist
        $user = Friends::where("friend_id",auth()->id())->where("user_id",$id)->firstOrFail();

        //accept the friend
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
        //check if the friendship exist and delete
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
