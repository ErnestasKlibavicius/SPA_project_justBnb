<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

class userBookingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth.role:user');
    }

    public function index($user_id){
        if(auth()->user()->hasRole('admin') || auth()->user()->id == $user_id) {
            $bookings = Booking::where('user_id',$user_id)->get();

            return response()->json([
                'data' => $bookings
            ]);
        }
        return response()->json([
            "status" => "403",
            "message" =>  "Uppss... you cannot be peeking here"
        ], 403);
    }
}
