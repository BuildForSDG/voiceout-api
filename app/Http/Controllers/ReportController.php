<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\User;
use App\Institution;
use App\Vote;
use App\Comment;


class ReportController extends Controller
{


    public function __construct() 
    {
        if (array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) {
            $this->middleware('auth:sanctum');
        }
    
        // $this->middleware('auth:sanctum');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $state = $request->query('state');
        $limit = $request->query('limit');


        if ($state && $limit) {
            $reports = Report::where('state', $state)->take($limit)->get();
            return response()->json($reports);

        } elseif ($state) {
            $reports = Report::where('state', $state)->get();
           return response()->json($reports);

        } elseif ($limit) {
            $reports = Report::take($limit)->get();
            return response()->json($reports);
        }

        $reports = Report::with('user')->get();
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


        $user = auth('sanctum')->user();
        $sector_id = json_decode($request->sector_id);

        $report = $user->reports()->create([
           'title' => $request->title,
           'description' => $request->description,
           'institution_name' => $request->institution_name,
           'address' => $request->address,
           'state' => $request->state
       ]);

        if ($sector_id) {
            $report->sector()->attach($sector_id);
        }
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

        $report = $report->load('user');

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
        $report = $report->load('comments', 'user');

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
    public function destroy(Request $request, $id)
    {
    }

    public function upvote(Request $request, $id) {

        $user = auth('sanctum')->user();
        $user_id = $user->id;

        $vote = Vote::firstOrNew([
            'user_id' => $user_id,
            'report_id' => $id,
        ]);

        $vote->vote = true;
        $vote->save();

        $response = [
            'vote' => $vote,
            'message' => 'upvoted successfully'
        ];
        return response($response, 201);
    }

    public function downvote(Request $request, $id) {

        //return error if d report doesn't exist

        $user = auth('sanctum')->user();
        $user_id = $user->id;

        $vote = Vote::firstOrNew([
            'user_id' => $user_id,
            'report_id' => $id
        ]);

        $vote->vote = false;
        $vote->reason = $request->reason;
        $vote->save();
        

        $response = [
            'vote' => $vote,
            'message' => 'downvoted successfully'
        ];
        return response($response, 201);
    }

    public function comment(Request $request, $id) {

        // $id = $request->report_id;
        $report = Report::find($id);
        if (!$report) {
            return;
        }

        $comment = $report->comments()->create([
            'description' => $request->description
        ]);

        $user = auth('sanctum')->user();
        $comment->user_id = $user->id;
        $comment->save();

        $response = [
            'comment' => $comment,
            'message' => 'comment successful'
        ];
        return response($response, 201);
    }

    public function comments(Request $request, $id) {

        // $id = $request->hi;
        $report = Report::find($id);

        if (!$report) {
            return;
        }
        
        $comments = Comment::where('report_id', $id)->get();
        return response()->json($comments);

    }

}
