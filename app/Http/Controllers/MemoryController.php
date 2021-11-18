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
        dd($request);
       $request->validate([
            'name' => 'required|min:5|max:30',
        ]);

        $userid = $request->user()->id;


        $memory = new Memory();
        $memory->name = $request->name;
        $memory->user_id = $userid;
        $memory->visited_date = $request->visited_date;
        $memory->location = new Point(10,20,4326);
        $memory->save();

        return inertia('Memory/Show',compact('memory'))
                        ->with('success','Memory created successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function show(Memory $memory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Memory  $memory
     * @return \Illuminate\Http\Response
     */
    public function edit(Memory $memory)
    {
        //
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
