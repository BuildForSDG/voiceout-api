<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use App\User;
use App\Institution;
use App\Vote;
use App\Comment;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReportCase;




class ReportController extends Controller
{


    public function __construct() 
    {
        if (array_key_exists('HTTP_AUTHORIZATION', $_SERVER)) {
            $this->middleware('auth:sanctum');
        }
    
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
        $sector = $request->query('sector');



        // if ($state || $limit) {
        //     $reports = Report::with('user')->where('state', $state)->take($limit)->get();
        //     return response()->json($reports);

        // }


        if ($state && $limit) {
            $reports = Report::with(['user', 'sector'])->where('state', $state)->take($limit)->get();
            return response()->json($reports);

        } elseif ($state) {
            $reports = Report::with(['user', 'sector'])->where('state', $state)->get();
           return response()->json($reports);

        } elseif ($limit) {
            $reports = Report::with(['user', 'sector'])->take($limit)->get();
            return response()->json($reports);
        } elseif ($sector) {
           $reports = Report::with(['user'])->whereHas('sector', function($q) use ($sector) {
                $q->where('name', '=', $sector);
           })->get();
           return response()->json($reports);
        }

        $reports = Report::with( ['user', 'sector'] )->get();
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
        $sectors = $request->sector_id;

        // error_log($request->sector_id);

        $report = $user->reports()->create([
           'title' => $request->title,
           'description' => $request->description,
           'institution_name' => $request->institution_name,
           'address' => $request->address,
           'state' => $request->state,
           'anonymous' => $request->anonymous
       ]);

        if ($sectors) {
            $report->sector()->attach($sectors);
        }
        $report->save();

        if ( $request->hasFile('image') ) {

            if ( $request->file('image')->isValid() ) {
                $report->addMediaFromRequest('image')->toMediaCollection('images', 's3');
            }  
        }

        if ( $request->hasFile('video') ) {
            if ( $request->file('video')->isValid() ) {
                $report->addMediaFromRequest('video')->toMediaCollection('videos', 's3');
            }
        }

        $report = $report->load('user', 'sector');

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
        $report = $report->load('comments', 'user', 'sector');

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

        $comment = $comment->load('user:id,first_name,last_name,email');
        $response = [
            'comment' => $comment,
            'message' => 'comment successful'
        ];
        return response()->json($response, 201);
    }

    public function comments(Request $request, $id) {

        // $id = $request->hi;
        $report = Report::find($id);

        if (!$report) {
            return;
        }
        
        $comments = Comment::where('report_id', $id)->with('user:id,first_name,last_name,email')->get();
        return response()->json($comments);

    }

    public function mail(Request $request, $id) {

        // Mail::to($request->user())->send(new ReportCase());

        $report = Report::find($id);

        $report_description = $report->description;
        $imageUrl = $report->media_url['images'];
        $videoUrl = $report->media_url['videos'];
        $reportUrl = 'https://voiceout.netlify.app/report/' . $report->id;

        if ($imageUrl) {   
            $imageUrl = $imageUrl[0];
        }

        if ($videoUrl) {
            $videoUrl = $videoUrl[0];
        }


        foreach (['toyinadesina60@gmail.com'] as $recipient) {
            Mail::to($recipient)->send(new ReportCase($report_description, $imageUrl, $videoUrl, $reportUrl));
        }

        $response = [
            'message' => 'email sent successfully'
        ];

        return response()->json($response);
    }

}
