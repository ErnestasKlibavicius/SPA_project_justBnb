<?php

namespace App\Http\Controllers\Api;

use App\Models\Bookable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class BookableAuthorController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth.role:user');
    }
    /**
     * bookable Author
     *
     * Get the bookable resource author.
     * @group Bookable
     * @header Authorization: Bearer your_token
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        $bookable = Bookable::findOrFail($id);

        return response()->json([
            'data' => $bookable->user
        ]);
    }
}
