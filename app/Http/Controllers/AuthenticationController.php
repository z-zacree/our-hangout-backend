<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;

class AuthenticationController extends Controller
{
    /**
     * Create a new AuthController instance.
     * Set middleware for logout & account functions
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @param  Request $request
     * 
     * @return JsonResponse
     */
    public function register(Request $request)
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
            'avatar' => ['nullable', 'string'],
        ]);

        $user = User::create([
            'avatar' => $request->avatar,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'description' => 'Just another user',
        ]);

        $token = Auth::login($user);
        $user->bookmarks = [];

        return response()->json([
            'message' => 'User created successfully',
            'token' => $token,
            'account' => $user
        ], 201);
    }

    /**
     * Login user and create token
     * 
     * @param  Request $request
     * 
     * @return JsonResponse
     */
    public function login(Request $request)
    {
        $emailCred = $request->only('email', 'password');
        $userCred = $request->only('username', 'password');

        if ($token = Auth::setTTL($request->stay ? 10800 : 3600)->attempt($emailCred)) {

            $user = Auth::user();

            $user->bookmarks = Bookmark::where('user_id', $user->id)->pluck('post_id');

            return response()->json([
                'message' => 'User logged in successfully by email',
                'token' => $token,
                'account' => $user,
            ], 200);
        } else if ($token = Auth::setTTL($request->stay ? 10800 : 3600)->attempt($userCred)) {

            $user = Auth::user();

            $user->bookmarks = Bookmark::where('user_id', $user->id)->pluck('post_id');

            return response()->json([
                'message' => 'User logged in successfully by username',
                'token' => $token,
                'account' => $user,
            ], 200);
        } else {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return JsonResponse
     */
    public function logout()
    {
        Auth::logout();

        return response()->json(['message' => 'Successfully logged out']);
    }
}
