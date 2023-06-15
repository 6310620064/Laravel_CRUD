<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Gate;


class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $posts = Post::where('user_id', $user->id)->latest()->paginate(5);
        return view('posts.index', compact('posts'))
                ->with('i', (request()->input('page', 1) -1) *5);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $post = new Post();
        $post->title = $request->title;
        $post->description = $request->description;
        $post->user_id = auth()->user()->id;
        $post->save();

        return redirect()->route('posts.index')
            ->with('success', 'Post created successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // กรณีให้userอื่นเห็นpostได้ แต่ไม่ให้update
        // if (Gate::denies('edit-post', $post)) {
        //     abort(403, 'Unauthorized');
        // }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $post->update([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        
        return redirect()->route('posts.index')
                        ->with('success','Post updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // กรณีให้userอื่นเห็นpost แต่ไม่ให้ delete
        // if (Gate::denies('delete-post', $post)) {
        //     abort(403, 'Unauthorized');
        // }
        
        $post->delete();
        return redirect()->route('posts.index')
                        ->with('success','Post deleted successfully');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }

}
