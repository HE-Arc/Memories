<?php

namespace App\Http\Controllers;

use App\Models\Memory;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

use Illuminate\Http\Request;
use Grimzy\LaravelMysqlSpatial\Types\Point;

class MemoryController extends Controller
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
        $memories = $user->memoriesAndPictures();
        return inertia('Memories/Index',compact('id','memories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return inertia('Memories/Create');
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
            'name' => 'required|min:5|max:30',
            'visited_date' => 'required|date|before_or_equal:today',
            'latlng' => 'required',
            'publishing' => 'required|in:private,public,friends-only'
        ]);


        $userid = $request->user()->id;

        $memory = new Memory();
        $memory->name = $request->name;
        $memory->user_id = $userid;
        $memory->description = $request->description;
        $memory->visited_date = $request->visited_date;
        $memory->location = new Point($request->latlng[0],$request->latlng[1],4326);
        $memory->publishing = $request->publishing;
        $memory->save();

        return inertia('Memories/Show',compact('memory'))
                    ->with(['flash.success' => "Memory created successfully"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Memory  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $memory = Memory::with('user')->with('pictures')->findOrFail($id);

        if (!Gate::allows('show-memory', $memory)) {
            abort(403);
        }

        return inertia('Memories/Show',compact('memory')) ;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $memory = Memory::findOrFail($id);

        if (!Gate::allows('memory-owner', $memory)) {
            abort(403);
        }

        return inertia('Memories/Edit',compact('memory')) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Memory  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Memory $memory)
    {
        $request->validate([
            'name' => 'required|min:5|max:30',
            'visited_date' => 'required|date|before_or_equal:today',
            'latlng' => 'required',
            'publishing' => 'required|in:private,public,friends-only'
        ]);

        $memoryOld = Memory::findOrFail($memory->id);

        if (!Gate::allows('memory-owner', $memoryOld)) {
            abort(403);
        }

        $memoryOld->name = $request->name;
        $memoryOld->description = $request->description;
        $memoryOld->visited_date = $request->visited_date;
        $memoryOld->location = new Point($request->latlng[0],$request->latlng[1],4326);
        $memoryOld->publishing = $request->publishing;
        $memoryOld->save();

        return redirect()->route('memories.show',['memory' => $memoryOld])
                    ->with('success','Memory deleted successfully');
                }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $memory = Memory::findOrFail($id);

        if (!Gate::allows('memory-owner', $memory)) {
            abort(403);
        }

        $memory->delete();

        return redirect()->route('memories.index')
                        ->with('success','Memory deleted successfully');

    }


}
