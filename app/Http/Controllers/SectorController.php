<?php

namespace App\Http\Controllers;

use App\Sector;
use App\Report;
use Illuminate\Http\Request;

class SectorController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $sectors = Sector::all();
         return response()->json($sectors);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $sector = Sector::create([
            'name' => $request->name; 
        ]);

        $response = [
            'sector' => $sector,
            'message' => 'sector created successfully'
        ];
        return response($response, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function show(Sector $sector)
    {

        $sector = $sector->load('reports');

        if ($sector) {
        return response()->json($sector);

        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sector $sector)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sector  $sector
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sector $sector)
    {
        //
    }

    public function reports(Request $request, $id) {

        $sector = Sector::find($id);
        $reports = $sector->reports;
        return response()->json($reports);

    }
}
