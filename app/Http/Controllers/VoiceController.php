<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Voice;

class VoiceController extends Controller
{


    public function __construct() 
    {

    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        // $voices = Voice::with('reports')->get();

        $voices = \App\Voice::all();
        return response()->json($voices);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $voice = \App\Voice::create([
            'name' => $request->name,
            'description' => $request->description,
            'email' => $request->email,
            'facebook' => $request->facebook,
            'twitter' => $request->twitter,
            'web' => $request->web,
            'address' => $request->address,
            'logo' => $request->logo
        ]);


        $response = [
            'voice' => $voice,
            'message' => 'voice created successfully'
        ];
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Voice $voice)
    {
        if ($voice) {

            $voice = $voice->load('reports');
            return response()->json($voice);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $voice = \App\Voice::find($id);
        $voice->twitter = $request->twitter;
        $voice->facebook = $request->facebook;
        $voice->save();
        return response()->json($voice);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $voice = \App\Voice::find($id);
        $voice->delete();
    }
}
