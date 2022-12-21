<?php

namespace App\Http\Controllers\Api;

use App\Models\Review;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReviewResource;
use App\Models\Booking;

/**
 * @group Review
 *
 * Routes for managing the review resource
 *
 */

class ReviewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth.role:user', ['except' => 'index']);
    }

    /**
     * Index
     *
     * Display a listing of the resource.
     *
     * @header Authorization: Bearer your_token
     */
    public function index()
    {
        return Review::all();
    }


    /**
     * Show
     *
     * Show the specified review.
     *
     * @header Authorization: Bearer your_token
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new ReviewResource(Review::findOrFail($id));
    }


    /**
     * Create
     *
     * Create new review
     *
     * @header Authorization: Bearer your_token
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'id' => 'required|size:36|unique:reviews',
            'content' => 'required|min:2',
            'rating' => 'required|in:1,2,3,4,5'
        ]);

        $booking = Booking::findByReviewKey($data['id']);

        if($booking === null) {
            return abort(404);
        }

        $booking->review_key = '';
        $booking->save();

        $review = Review::make($data);

        $review->booking_id = $booking->id;
        $review->bookable_id = $booking->bookable_id;
        $review->save();

        return new ReviewResource($review);
    }


    /**
     * Update
     *
     * Update the review
     *
     * @header Authorization: Bearer your_token
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request)
    {
        $review = Review::findOrFail($id);

        $data = $request->validate([
            'content' => 'sometimes',
            'rating' => 'sometimes'
        ]);

        $review->update([
            'content' => array_key_exists('content', $data) ? $data['content'] : "",
            'rating' => array_key_exists('rating', $data) ? $data['rating'] : 5
        ]);

        // return new ReviewResource($review);
        return $review;
    }


    /**
     * Delete
     *
     * Delete the review
     *
     * @header Authorization: Bearer your_token
     * @return \Illuminate\Http\Response
     */

    public function destroy($id)
    {
        $review = Review::findOrFail($id);

        $review->delete();

        return $review;
    }
}
