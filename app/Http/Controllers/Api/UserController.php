<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

/**
 * @group User
 *
 * Routes for managing the user resource
 *
 */

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth.role:user', ['except' => 'store']);
    }
    /**
     * index
     *
     * Display a listing of the users.
     *
     * @header Authorization: Bearer your_token
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(auth()->user()->hasRole('admin')) {
            return User::all();
        }

        return  response()->json([
            "status" => "403",
            "message" =>  "Uppss... you cannot be peeking here"
        ], 403);
    }

    /**
     * Create
     *
     * Store a newly created user in storage.
     *
     * @header Authorization: Bearer your_token
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password'],
        ]);

        $user->assignRole('user');

        return $user;
    }

    /**
     * Show
     *
     * Display the specified user.
     *
     * @header Authorization: Bearer your_token
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if(auth()->user()->id == $id || auth()->user()->hasRole('admin')) {
            return User::findOrFail($id);
        }

        return  response()->json([
            "status" => "403",
            "message" =>  "Uppss... you cannot be peeking here"
        ], 403);
    }

    /**
     * Update
     *
     * Update the specified user in storage.
     * @header Authorization: Bearer your_token
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if(auth()->user()->hasRole('admin') || auth()->user()->id == $id) {
            $data = $request->validate([
                'name' => 'sometimes',
                'email' => 'sometimes',
                'password' => 'sometimes|min:8'
            ]);

            $user->update([
                'name' => array_key_exists('name', $data) ? $data['name'] : $user->name,
                'email' => array_key_exists('email', $data) ? $data['email'] : $user->email,
                'password' => array_key_exists('password', $data) ? Hash::make($data['password']) : $user->password,
            ]);

            return $user;
        }

        return  response()->json([
            "status" => "403",
            "message" =>  "Uppss... you cannot be peeking here"
        ], 403);

    }

    /**
     * Delete
     *
     * Remove the specified user from storage.
     *
     * @header Authorization: Bearer your_token
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if(auth()->user()->hasRole('admin') ) {
            $user->delete();
            return $user;
        }

        return  response()->json([
            "status" => "403",
            "message" =>  "Uppss... you cannot be peeking here"
        ], 403);

    }
}
