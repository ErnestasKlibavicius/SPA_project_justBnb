<?php

namespace App\Http\Controllers\Api;

use App\Models\Bookable;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class BookablePriceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Price check
     *
     * Check the price of the bookable resource
     * @group Bookable
     *
     * @response status=200 {
     * "data": {
     * "total": 132,
     * "breakdown": {
     * "33": 4
     * }
     * }
     * }
     *
     * @response status=401 {
     * "message": "Unauthenticated"
     * }
     *
     * @header Authorization: Bearer your_token
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($id, Request $request)
    {
        $bookable = Bookable::findOrFail($id);

        $data = $request->validate([
            'from' => 'required|date_format:Y-m-d',
            'to' => 'required|date_format:Y-m-d|after_or_equal:from'
        ]);

        return response()->json([
            'data' => $bookable->priceFor($data['from'], $data['to'])
        ]);
    }
}
