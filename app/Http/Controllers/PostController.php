<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Category;
use App\Models\PostCategory;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rawPosts = Post::all();

        foreach ($rawPosts as $rawPost) {
            $cat_ids = PostCategory::where('post_id', $rawPost->id)->pluck('category_id');
            foreach ($cat_ids as $cat_id) {
                $catnames[] = Category::where('id', $cat_id)->first();
            }

            $rawPost->categories = $catnames;
            $rawPost->bookmarks = count(Bookmark::where('post_id', $rawPost->id)->get());
            $rawPost->author = User::where('id', $rawPost->user_id)->first()->only(['id', 'username', 'avatar']);
            $catnames = [];
        }

        return $rawPosts;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        Post::where('id', $id)->increment('views', 1);

        $post = Post::where('id', $id)->get()->first();
        $cat_ids = PostCategory::where('post_id', $post->id)->pluck('category_id');
        foreach ($cat_ids as $cat_id) {
            $catnames[] = Category::where('id', $cat_id)->first();
        }

        $post->categories = $catnames;
        $post->bookmarks = count(Bookmark::where('post_id', $post->id)->get());
        $post->author = User::where('id', $post->user_id)->first();

        return $post;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return Post::where('id', $id)->delete();
    }
}
