<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Institution;
use App\Report;


class InstitutionController extends Controller
{


    public function __construct() 
    {
        $this->middleware('auth:sanctum');
    }

    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $institutions = \App\Institution::with( ['owner'] )->get();

        // $institutions = Institution::all();

        return response()->json($institutions);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

         $institution = \App\Institution::create([
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
        ]);


         $response = [
            'institution' => $institution,
            'message' => 'institution created successfully'
        ];
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Institution $institution)
    {
        if ($institution) {
            $institutions = $institution->load('owner', 'reports', 'followers');
            return response()->json($institution);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function reports(Request $request, $id) {
        $reports = \App\Report::where('institution_id', $id)->get();
        return response()->json($reports);
    }

    public function followers(Request $request, $id) {
        $institution = \App\Institution::find($id);
        $followers = $institution->followers;
        return response()->json($followers);
    }
}
