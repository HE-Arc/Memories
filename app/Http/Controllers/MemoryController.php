<?php

namespace App\Http\Controllers;

use App\Models\Memory;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Support\Facades\Storage;

/**
 * MemoryController
 * Manage all the logic between views and model for memory feature
 */
class MemoryController extends Controller
{
    /**
     * Display a listing of memories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //find current user
        $id = auth()->id();
        $user = User::find($id);

        //get all memories with pictures of this user
        $memories = $user->memoriesAndPictures();

        //friends'memories
        $friendsMemoriesOfThisUser = $user->friendsMemoriesOfThisUser;
        $memoriesOfthisUserFriendOf = $user->memoriesOfthisUserFriendOf;
        $memoriesFriends = $friendsMemoriesOfThisUser->merge($memoriesOfthisUserFriendOf);

        //public memories
        $publicMemories = Memory::publicMemories();

        //return all memories to the views
        return inertia('Memories/Index',compact('id','memories','memoriesFriends','publicMemories'));
    }

    /**
     * Show the form for creating a new memory.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       //return the create view
       return inertia('Memories/Create');
    }

    /**
     * Store a newly created memory in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //check if request is correct
       $request->validate([
            'name' => 'required|min:5|max:30',
            'visited_date' => 'required|date|before_or_equal:today',
            'latlng' => 'required',
            'publishing' => 'required|in:private,public,friends-only'
        ]);

        //find the current user
        $userid = $request->user()->id;

        //build and store new memories from request data
        $memory = new Memory();
        $memory->name = $request->name;
        $memory->user_id = $userid;
        $memory->description = $request->description;
        $memory->visited_date = $request->visited_date;
        $memory->location = new Point($request->latlng[0],$request->latlng[1],4326);
        $memory->publishing = $request->publishing;
        $memory->save();

        //send the memory with all information (user, picture) to the view
        $memory = Memory::with('user')->with('pictures')->findOrFail($memory->id);

        return inertia('Memories/Show',compact('memory'))
                    ->with(['flash.success' => "Memory created successfully"]);
    }

    /**
     * Display the specified memory.
     *
     * @param  \App\Models\Memory  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get memories with its pictures
        $memory = Memory::with('user')->with('pictures')->findOrFail($id);

        //check if the user is authorized to access the memory
        if (!Gate::allows('show-memory', $memory)) {
            abort(403);
        }

        //return the view with data
        return inertia('Memories/Show',compact('memory')) ;
    }

    /**
     * Show the form for editing the specified memory.
     *
     * @param  $id memory's id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //find the memory to edit
        $memory = Memory::findOrFail($id);

        //check if the user is authorized to access the memory
        if (!Gate::allows('memory-owner', $memory)) {
            abort(403);
        }

        //return the view with data
        return inertia('Memories/Edit',compact('memory')) ;
    }

    /**
     * Update the specified memory in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Memory  memory to update
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Memory $memory)
    {
        //check if the request is correct
        $request->validate([
            'name' => 'required|min:5|max:30',
            'visited_date' => 'required|date|before_or_equal:today',
            'latlng' => 'required',
            'publishing' => 'required|in:private,public,friends-only'
        ]);

        //check if the memory exists in the database
        $memoryOld = Memory::findOrFail($memory->id);

        //check if the user is authorized to update the memory (only owner)
        if (!Gate::allows('memory-owner', $memoryOld)) {
            abort(403);
        }

        //update the memory with the request data
        $memoryOld->name = $request->name;
        $memoryOld->description = $request->description;
        $memoryOld->visited_date = $request->visited_date;
        $memoryOld->location = new Point($request->latlng[0],$request->latlng[1],4326);
        $memoryOld->publishing = $request->publishing;
        $memoryOld->save();

        //redirect the view with the memory updated
        return redirect()->route('memories.show',['memory' => $memoryOld])
                    ->with('success','Memory updated successfully');
                }

    /**
     * Remove the specified memory from storage.
     *
     * @param  $id memory's id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //check if the memory exists in the database
        $memory = Memory::findOrFail($id);

        //check if the user is authorized to delete the memory (only owner)
        if (!Gate::allows('memory-owner', $memory)) {
            abort(403);
        }

        //delete potential images from the server (clean, we don't want to keep useless files)
        $src = "public/" . auth()->id() .'/'. $memory->id;
        Storage::deleteDirectory($src);

        //delete the memory
        $memory->delete();

        //redirect to the memories list
        return redirect()->route('memories.index')
                        ->with('success','Memory deleted successfully');

    }


}
