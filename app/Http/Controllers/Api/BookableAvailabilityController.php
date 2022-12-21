<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bookable;
use Illuminate\Http\Request;

class BookableAvailabilityController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }


    /**
     * Availability
     *
     * Check the availability of the bookable resource
     *
     *
     * @group Bookable
     * @header Authorization: Bearer your_token
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     *
     * @response status=200 {
     * []
     * }
     *
     *
     * @response status=401 {
     * "message": "Unauthenticated"
     * }
     */
    public function __invoke($id, Request $request)
    {
        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d|after_or_equal:now',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from'
        ]);

        $bookable = Bookable::findOrFail($id);

        return $bookable->availableFor($data['from'], $data['to'])
            ? response()->json([])
            : response()->json([], 404);
    }
}
