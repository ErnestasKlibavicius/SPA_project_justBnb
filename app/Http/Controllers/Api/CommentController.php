<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Comment;
use App\Models\Bookable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

/**
 * @group Comment
 *
 * Routes for managing the comment resource
 *
 */

class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }
    /**
     * Index
     *
     * Display a listing of the resource.
     *
     * @header Authorization: Bearer your_token
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Comment::all();
    }

    /**
     * Create
     *
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @header Authorization: Bearer your_token
     * @return \Illuminate\Http\Response
     */
    public function store($post_id, $user_id, Request $request)
    {
        if(auth()->user()->hasRole('admin') || auth()->user()->id == $user_id) {
            $bookable = Bookable::findOrFail($post_id);
            $user = User::findOrFail($user_id);

            $data = $request->validate([
                'content' => 'required|min:3',
            ]);

            $comment = Comment::create([
                'content' => $data['content'],
                'user_id' => $user->id,
                'bookable_id' => $bookable->id,
            ]);

            return $comment;
        }

        return response()->json([
            "status" => "403",
            "message" =>  "Uppss... you cannot be peeking here"
        ], 403);

    }

    /**
     * Show
     *
     * Display the specified resource.
     *
     *
     * @header Authorization: Bearer your_token
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Comment::findOrFail($id);
    }

    /**
     * Update
     *
     * Update the specified resource in storage.
     *
     *
     * @header Authorization: Bearer your_token
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        $data = $request->validate([
            'content' => 'sometimes'
        ]);

        $comment->update([
            'content' => array_key_exists('content', $data) ? $data['content'] : $comment->content,
        ]);

        return $comment;
    }

    /**
     * Delete
     *
     * Remove the specified resource from storage.
     *
     * @header Authorization: Bearer your_token
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        $comment->delete();

        return $comment;
    }
}
