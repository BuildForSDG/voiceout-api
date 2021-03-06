<?php

namespace App\Http\Controllers;

use App\Http\Resources\User as UserResource;
use App\User;
use App\Report;

// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;

class UserController extends Controller
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

        $users = User::all();
        return response()->json($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //   return response()->json([
        //     'name' => 'Johnson',
        // ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json($user);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
       return response()->json($user);    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    public function reports(Request $request, $id) {
        $reports = Report::where('user_id', $id)->get();
        return response()->json($reports);
    }
}
