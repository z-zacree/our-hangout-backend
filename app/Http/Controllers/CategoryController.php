<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\Category;
use App\Models\User;
use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $categories = Category::all();

        if ($categories) {
            return response()->json($categories, 200);
        } else {
            return response()->json(['message' => 'No categories found'], 404);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $category = Category::where('name', $request->name)->get()->first();
        $post_ids = PostCategory::where('category_id', $category->id)->pluck('post_id');
        foreach ($post_ids as $post_id) {


            $post = Post::where('id', $post_id)->get()->first();
            $cat_ids = PostCategory::where('post_id', $post->id)->pluck('category_id');
            foreach ($cat_ids as $cat_id) {
                $catnames[] = Category::where('id', $cat_id)->first();
            }

            $post->categories = $catnames;
            $post->bookmarks = count(Bookmark::where('post_id', $post->id)->get());
            $post->author = User::where('id', $post->user_id)->pluck('username')->first();
            $catnames = [];

            $posts[] = $post;
        }
        if ($category) {
            return response()->json([
                'category' => $category,
                'posts' => $posts,
            ], 200);
        } else {
            return response()->json(['message' => 'Category not found'], 404);
        }
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
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, category $category)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(category $category)
    {
        //
    }
}
