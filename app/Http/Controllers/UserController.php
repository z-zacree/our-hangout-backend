<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\user;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new UserController instance.
     * Set middleware for all functions
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Get the authenticated User.
     *
     * @return JsonResponse
     */
    public function account()
    {
        $user = Auth::user();
        $user->bookmarks = Bookmark::where('user_id', $user->id)->pluck('post_id');
        return response()->json([
            'message' => 'User account successfully returned',
            'account' => $user
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'avatar' => ['nullable', 'string'],
            'username' => ['nullable', 'string', 'max:48', 'unique:users'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'description' => ['nullable', 'string'],
        ]);

        $authUser = Auth::user();

        $user = User::find($authUser->id);

        $user->avatar = $request->avatar;
        if (!empty($request->username)) {
            $user->username = $request->username;
        }
        if (!empty($request->email)) {
            $user->email = $request->email;
        }
        if (!empty($request->description)) {
            $user->description = $request->description;
        }
        $user->save();

        return response()->json([
            'message' => 'User updated successfully',
            'token' => $user->getJWTIdentifier(),
            'account' => $user
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(user $user)
    {
        //
    }
}
