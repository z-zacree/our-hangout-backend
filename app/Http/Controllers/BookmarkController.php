<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Bookmark;
use App\Models\PostCategory;
use App\Models\Category;
use App\Models\User;
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

    public function index()
    {
        $user = Auth::user();
        $postIds = Bookmark::where('user_id', $user->id)->pluck('post_id');
        foreach ($postIds as $postId) {
            $post = Post::where('id', $postId)->get()->first();
            $cat_ids = PostCategory::where('post_id', $post->id)->pluck('category_id');
            foreach ($cat_ids as $cat_id) {
                $catnames[] = Category::where('id', $cat_id)->first();
            }

            $post->categories = $catnames;
            $post->bookmarks = count(Bookmark::where('post_id', $post->id)->get());
            $post->author = User::where('id', $post->user_id)->first()->only(['id', 'username', 'avatar']);
            $posts[] = $post;
        }
        return $posts;
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
