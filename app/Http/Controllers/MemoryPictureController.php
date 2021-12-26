<?php

namespace App\Http\Controllers;

use App\Models\MemoryPicture;
use App\Models\Memory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Gate;


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
        //validate format image
        $request->validate([
            'file' => 'required|image|mimes:jpg,png,jpeg,gif,svg',
        ]);

        //retrieve memory if exist
        $idMemory = $request->input('id');
        $memory = Memory::findOrFail($idMemory);

        //check if user is allow to perform this opertation
        if (!Gate::allows('memory-owner', $memory)) {
            abort(403);
        }

        //save file --> /storage/idUser/idMemory/picturename
        $userid = $request->user()->id;
        $file = $request->file('file'); //get file
        $filename = $file->getClientOriginalName(); //get filename
        $path = "public/" . $userid .'/'. $idMemory;

        //store file
        $request->file('file')->storeAs($path, $filename);

        //save reference to the picture in database (via memory)
        $memoryPicture = new MemoryPicture();
        $memoryPicture->memory_id = $idMemory;
        $memoryPicture->picture_name = $filename;
        $memoryPicture->order = $memory->pictures->count()+1;
        $memoryPicture->save();

        //actualise memory with new data
        $memory = Memory::findOrFail($idMemory);

        //send to the view the images
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
        //check if the ressource exist
        $memoryPicture = MemoryPicture::find($id);

        //check if user is allow to perform this opertation
        if (!Gate::allows('memory-owner',  $memoryPicture->memory)) {
            abort(403);
        }

        //retrieve the path to the file
        $userid = auth()->id();
        $src = "public/" . $userid .'/'. $memoryPicture->memory_id . '/' . $memoryPicture->picture_name;

        //delete from storage
        Storage::delete($src);
        $memoryPicture->delete();

        //return information to the view
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

        //check if the ressource exist
        $memory = Memory::findOrFail($id);

        //check if user is allow to perform this opertation
        if (!Gate::allows('memory-owner', $memory)) {
            abort(403);
        }

        //send to the view memory with pictures their path
        $img = $memory->pictures;
        $userid = auth()->id();
        $src = "public/" . $userid .'/'. $memory->id . '/';
        $src = Storage::url($src);

        return inertia('Memories/Pictures',compact('memory','img','src')) ;
    }

      /**
     * Allow to swap the order between two pictures
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function order(Request $request)
    {
        //check if we got 2 id
        $request->validate([
            'id1' => 'required|integer|min:1',
            'id2' => 'required|integer|min:1',
        ]);

        //check if the pictures exist
        $memoryPicture1 = MemoryPicture::findOrFail($request->id1);
        $memoryPicture2 = MemoryPicture::findOrFail($request->id2);

        //check if user is allow to perform this opertation
        if (!Gate::allows('memory-owner', $memoryPicture1->memory)) {
            abort(403);
        }


        if (!Gate::allows('memory-owner', $memoryPicture2->memory)) {
            abort(403);
        }


        //swap the order of the 2 pictures
        $tmp = $memoryPicture1->order;
        $memoryPicture1->order = $memoryPicture2->order;
        $memoryPicture2->order = $tmp;
        $memoryPicture1->save();
        $memoryPicture2->save();


        //return information to the view
        return response()->json([
            'success' => true,
        ], 200);

    }
}
