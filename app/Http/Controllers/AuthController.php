<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

/**
 * @group Authentication JWT
 *
 * Routes for managing the authentication/registration of the user
 *
 */
class AuthController extends Controller
{

    public function __construct()
    {
//        $this->middleware('auth:api', ['except' => ['login', 'register']]);
        $this->middleware('auth.role:user', ['except' => ['login', 'register', 'logout']]);
    }

    /**
     * Login
     *
     * Authenticate the user to the system
     *
     * @response {
         * "status": "success",
         * "user": {
         * "id": 1,
         * "name": "Westley Langosh",
         * "email": "bartoletti.virginie@example.net",
         * "email_verified_at": "2022-12-15T19:44:54.000000Z",
         * "created_at": "2022-12-15T19:44:54.000000Z",
         * "updated_at": "2022-12-15T19:44:54.000000Z",
         * "roles": [
         * {
         * "id": 2,
         * "name": "user",
         * "guard_name": "api",
         * "created_at": "2022-12-15T19:44:54.000000Z",
         * "updated_at": "2022-12-15T19:44:54.000000Z",
         * "pivot": {
         * "model_id": 1,
         * "role_id": 2,
         * "model_type": "App\\Models\\User"
         * }
         * }
         * ]
         * },
         * "authorisation": {
         * "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGFyYXZlbC12dWUtc3BhLnRlc3QvYXBpL2xvZ2luIiwiaWF0IjoxNjcxNjI2NzAyLCJleHAiOjE2NzE3MTMxMDIsIm5iZiI6MTY3MTYyNjcwMiwianRpIjoiMEhhZ0RBTW9wSWpXUDI3aSIsInN1YiI6IjEiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3Iiwicm9sZXMiOlsidXNlciJdfQ.ZBZSeI3a2yY2-bmoKH-4YQKF2elFajdx7_CHuKUU6vg",
         * "type": "bearer"
         * }
     * }
     *
     *
     * @response status=401 scenario="Unauthenticated" {
     * "status": "error",
    * "message": "Unauthorized"
     * }
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('email', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        return response()->json([
            'status' => 'success',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }


    /**
     * Register
     *
     * Register new user to the system
     *
     * @response {
     * "status": "success",
     * "message": "User created successfully",
     * "user": {
     * "name": "kitas",
     * "email": "useris@email.comasdas",
     * "updated_at": "2022-12-21T12:47:41.000000Z",
     * "created_at": "2022-12-21T12:47:41.000000Z",
     * "id": 103,
     * "roles": [
     * {
     * "id": 2,
     * "name": "user",
     * "guard_name": "api",
     * "created_at": "2022-12-15T19:44:54.000000Z",
     * "updated_at": "2022-12-15T19:44:54.000000Z",
     * "pivot": {
     * "model_id": 103,
     * "role_id": 2,
     * "model_type": "App\\Models\\User"
     * }
     * }
     * ]
     * },
     * "authorisation": {
     * "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGFyYXZlbC12dWUtc3BhLnRlc3QvYXBpL3JlZ2lzdGVyIiwiaWF0IjoxNjcxNjI2ODYxLCJleHAiOjE2NzE3MTMyNjEsIm5iZiI6MTY3MTYyNjg2MSwianRpIjoia0ZCTUVGMVNKckk0bDlHZCIsInN1YiI6IjEwMyIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJyb2xlcyI6WyJ1c2VyIl19.EDtYXP8g7LpIz8dxU71H_unhH9KXEebMsvC8l1AIO0I",
     * "type": "bearer"
     * }
     * }
     *

     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole('user');

        $token = Auth::login($user);
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    /**
     * Logout
     *
     * Logout authenticated user
     * @header Authorization: Bearer your_token
     * @response {
     * "status": "success",
     * "message": "Successfully logged out"
     * }
     */
    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    /**
     * Refresh
     * @authenticated
     * @header Authorization: Bearer your_token
     * Refresh authenticated users JWT token
     *
     * @response {
     * "status": "success",
     * "user": {
     * "id": 1,
     * "name": "Westley Langosh",
     * "email": "bartoletti.virginie@example.net",
     * "email_verified_at": "2022-12-15T19:44:54.000000Z",
     * "created_at": "2022-12-15T19:44:54.000000Z",
     * "updated_at": "2022-12-15T19:44:54.000000Z"
     * },
     * "authorisation": {
     * "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGFyYXZlbC12dWUtc3BhLnRlc3QvYXBpL3JlZnJlc2giLCJpYXQiOjE2NzE2MjY0MTIsImV4cCI6MTY3MTcxMjgyMCwibmJmIjoxNjcxNjI2NDIwLCJqdGkiOiJ2MFExUW5RSWxoQzFzMXdYIiwic3ViIjoiMSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjciLCJyb2xlcyI6WyJ1c2VyIl19.1TvkMmjrMFxfnxkoYTsOgXbZbJpF7wOUB9N-Bw1s12w",
     * "type": "bearer"
     *}
     *}
     *
     * @response status=401 scenario="Unauthenticated" {
     * "message": "Your token is invalid. Please, login again.",
     * "success": false
     * }
     */

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
