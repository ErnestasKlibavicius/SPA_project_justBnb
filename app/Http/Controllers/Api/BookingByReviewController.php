<?php

namespace App\Http\Controllers\Api;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\BookingByReviewShowResource;

class BookingByReviewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['index', 'show']]);
    }

    /**
     * Booking by review
     *
     * Get booking by review.
     *
     *
     * @response status=200 {
     * "data": {
     * "booking_id": 5,
     * "from": "2023-03-08",
     * "to": "2023-03-22",
     * "bookable": {
     * "bookable_id": 1,
     * "title": "Lemketown Cheap House",
     * "description": "Explicabo iure molestiae doloremque dolorem dolorum. Rerum quaerat odio eos. Quaerat molestiae aut ratione."
     * }
     * }
     * }
     *
     * @response status=401 {
     * "message": "Unauthenticated"
     * }
     * @group Booking
     * @header Authorization: Bearer your_token
     * @queryParam $reviewKey uuid
     * @return \Illuminate\Http\Response
     */
    public function __invoke($reviewKey, Request $request)
    {
        $booking = Booking::findByReviewKey($reviewKey);
        return $booking ? new BookingByReviewShowResource($booking) : abort(404);
    }
}
