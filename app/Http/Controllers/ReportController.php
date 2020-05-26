<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\User;
use App\Institution;


class ReportController extends Controller
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

        $reports = Report::with(['user', 'institution'])->get();
        return response()->json($reports);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //verify


        $id = $request->institution_id;
        $institution = Institution::find($id);
        $user = auth('sanctum')->user();

        $new = $request->new_institution;
        $response = null;

        if (!$new) {

            $report = $user->reports()->create([
               'title' => $request->title,
               'description' => $request->description,
               'sector' => $request->sector
           ]);

            $report->institution()->associate($institution);
            $report->save();

            if ( $request->hasFile('image') ) {
                if ( $request->file('image')->isValid() ) {
                    $report->addMediaFromRequest('image')->toMediaCollection('images');
                }  

            }

            if ( $request->hasFile('video') ) {
                if ( $request->file('video')->isValid() ) {
                    $report->addMediaFromRequest('video')->toMediaCollection('videos');
                }
            }

        } else {
               $institution = Institution::create([
                    'name' => $request->institution_name,
                    'description' => $request->institution_description,
                    'address' => $request->address,
                ]);

               $report = $institution->reports()->create([
                    'title' => $request->title,
                    'description' => $request->description,
                    'sector' => $request->sector
                ]);

               $report->user()->associate($user);
        }
        
        $media = [
            'image' => null,
            'video' => null
        ];

        $report = $report->load('institution', 'institution.followers', 'user');
        $response = [
            'report' => $report,
            'message' => 'Report successful'
        ];

        return response($response, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        $report = $report->load('votes', 'comments');

        if ($report) {
            return response()->json($report);

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
}
