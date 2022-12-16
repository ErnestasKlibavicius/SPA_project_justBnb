<?php

namespace App\Http\Controllers\Api;

use App\Models\Bookable;
use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookableIndexResource;
use App\Http\Resources\BookableShowResource;

class BookableController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return BookableIndexResource::collection(
            Bookable::all()
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'price' => 'required',
            'user_id' => 'required'
        ]);

        $bookable = Bookable::create([
            'title' => $data['title'],
            'description' => $data['description'],
            'price' =>  $data['price'],
            'user_id' =>  $data['user_id']
        ]);

        return $bookable;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new BookableShowResource(Bookable::findOrFail($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $bookable = Bookable::findOrFail($id);

        $data = $request->validate([
            'title' => 'sometimes',
            'description' => 'sometimes',
            'price' => 'sometimes'
        ]);

        $bookable->update([
            'title' => array_key_exists('title', $data) ? $data['title'] : "",
            'description' => array_key_exists('description', $data) ? $data['description'] : "",
            'price' => array_key_exists('price', $data) ? $data['price'] : 0,
        ]);

        return $bookable;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $bookable = Bookable::findOrFail($id);
        if(auth()->user()->hasRole('admin') || auth()->user()->id == $bookable->user->id) {
            $bookable->delete();
            if(Review::where('bookable_id', $bookable->id)->count() > 0) {
                Review::where('bookable_id', $bookable->id)->delete();
            }
            return $bookable;
        }

        return response()->json([
            "status" => "403",
            "message" =>  "Uppss... you cannot be peeking here"
        ], 403);

    }
}
