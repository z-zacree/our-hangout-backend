<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookmarkController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        $postId = $request->id;

        Bookmark::create([
            'user_id' => $user->id,
            'post_id' => $postId,
        ]);

        $user->bookmarks = Bookmark::where('user_id', $user->id)->pluck('post_id');

        return response()->json([
            'message' => 'Bookmark successfully created',
            'account' => $user
        ], 201);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request  $request)
    {
        $user = Auth::user();

        $postId = $request->id;

        Bookmark::where('user_id', $user->id)->where('post_id', $postId)->delete();

        $user->bookmarks = Bookmark::where('user_id', $user->id)->pluck('post_id');

        return response()->json([
            'message' => 'Bookmark successfully deleted',
            'account' => $user
        ], 201);
    }
}
