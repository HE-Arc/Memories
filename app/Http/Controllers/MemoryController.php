<?php

namespace App\Http\Controllers;

use App\Models\Memory;
use App\Models\User;

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
        $memories = $user->memories;
        return inertia('Memories/Index',compact('memories'));
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
            'publishing' => 'required'
        ]);


        $userid = $request->user()->id;


        $memory = new Memory();
        $memory->name = $request->name;
        $memory->user_id = $userid;
        $memory->description = $request->description;
        $memory->visited_date = $request->visited_date;
        $memory->location = new Point($request->latlng[0],$request->latlng[1],4326);
        $memory->save();

        return inertia('Memories/Show',compact('memory'))
                        ->with('success','Memory created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Memory  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $memory = Memory::findOrFail($id);
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
        return inertia('Memories/Edit',compact('memory')) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Memory $memory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $memory = Memory::find($id);
        $memory->delete();

        return redirect()->route('memories.index')
                        ->with('success','Memory deleted successfully');

    }
}
