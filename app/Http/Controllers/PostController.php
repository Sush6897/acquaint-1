<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;


use Illuminate\Http\Request;


class PostController extends Controller
{
    //

    public function index(){
        $posts = Post::withCount('comments')->with('user', 'tags')->get();
        // dd($posts);
        return view('index', compact('posts'));

    }
    
    public function post(Request $request){
        
        $request->validate([
            'user_id' => 'required|email|string',
            'title' => 'required|string|max:25|unique:posts',
            'content' => 'required|string:max:250',
        ]);
        $user = User::where('email', $request->user_id)->first();
        if($user){
           $post =  Post::create([
                'title' => $request->title,
                'content' => $request->content,
                'user_id' => $user->id,
            ]);
            return response()->json(['success' => 'post created Successfully', $post], 200);

        }else{
            return response()->json(['error' => 'user_id not found'], 404);

        }
    }
    
    public function show(Post $post)
    {
        $post = Post::where('id', $post->id)->with('comments.user', 'tags')->get();

        return response()->json($post);
    }

    public function addComment(Request $request, Post $post)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment = $post->comments()->create([
            'user_id' =>auth()->user()->id, // Assuming you're using authentication
            'content' => $request->content,
            // 'post_id' => $post,
        ]);

        return response()->json($comment, 201);
    }

    public function addTag(Request $request, Post $post)
    {
        $request->validate([
            'name' => 'required|string|unique:tags',
        ]);

        $tag = Tag::firstOrCreate(['name' => $request->name]);

        $post->tags()->attach($tag->id);

        return response()->json($tag, 201);
    }


}
