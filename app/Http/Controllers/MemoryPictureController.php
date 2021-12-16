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

        $file = $request->file('file');
        $filename = $file->getClientOriginalName();
        $path = $userid .'/'. $idMemory .'/'. $filename;

        if(Storage::disk('uploads')->put($path, $file)) {
          /*  $id = $request->input('id');
            $memory = Memory::find($id);
            $journey->video_path = $path;
            $journey->save();*/

            return response()->json([
                'success' => true
            ], 200);
        }
        return response()->json([
            'success' => false
        ], 500);


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
        return inertia('Memories/Pictures',compact('memory')) ;
    }
}
