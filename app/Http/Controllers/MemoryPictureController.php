<?php

namespace App\Http\Controllers;

use App\Models\MemoryPicture;
use App\Models\Memory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MemoryPictureController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        $userid = $request->user()->id;
        $idMemory = $request->input('id');
        $memory = Memory::findOrFail($idMemory);

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $path = "public/" . $userid .'/'. $idMemory;

        $request->file('file')->storeAs($path, $filename);

        $memoryPicture = new MemoryPicture();
        $memoryPicture->memory_id = $idMemory;
        $memoryPicture->picture_name = $filename;
        $memoryPicture->order = $memory->pictures->count()+1;
        $memoryPicture->save();

        return response()->json([
            'success' => true,
            'path' => Storage::url($path).'/',
            'images' => $memory->pictures
        ], 200);


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MemoryPicture  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $memoryPicture = MemoryPicture::find($id);
        $userid = auth()->id();
        $src = "public/" . $userid .'/'. $memoryPicture->memory_id . '/' . $memoryPicture->picture_name;
        Storage::delete($src);
        $memoryPicture->delete();

        return response()->json([
            'success' => true,
        ], 200);

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
        $img = $memory->pictures;
        $userid = auth()->id();
        $src = "public/" . $userid .'/'. $memory->id . '/';
        $src = Storage::url($src);

        return inertia('Memories/Pictures',compact('memory','img','src')) ;
    }

      /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request)
    {
        $request->validate([
            'id1' => 'required|integer|min:1',
            'id2' => 'required|integer|min:1',
        ]);

        $memoryPicture1 = MemoryPicture::findOrFail($request->id1);
        $memoryPicture2 = MemoryPicture::findOrFail($request->id2);

        $tmp = $memoryPicture1->order;
        $memoryPicture1->order = $memoryPicture2->order;
        $memoryPicture2->order = $tmp;
        $memoryPicture1->save();
        $memoryPicture2->save();


        return response()->json([
            'success' => true,
        ], 200);

    }
}
