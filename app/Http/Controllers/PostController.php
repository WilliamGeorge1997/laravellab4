<?php

namespace App\Http\Controllers;
use App\Models\Post;
use App\Models\User;
use App\Events\PostCreated;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('user')->paginate(10);
        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       // $users = User::all();
        //return view('posts.create', ['users' => $users]);
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    $data = $request->all();
    $data['slug'] = Str::slug($data['title']);

    $user_id = auth()->id();
    $data['user_id'] = $user_id;

    $post = Post::create($data);

    event(new PostCreated($post));
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if($post = Post::find($id)){
            return view('posts.show', ['post'=> $post]);
        }else
        return  redirect()->route('posts.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $post = Post::with('user')->find($id);
        $users = User::all();
        return view('posts.edit',['post' => $post, 'users' => $users ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        

        $post = Post::find($id);
        if (auth()->id() == $post->user_id) {


        Post::where('id', $id)->update([
            'title' => $request->title,
            'slug' => Str::slug($request['title']),
            'body' => $request->body,
            'user_id' => auth()->id()
            ]);

            return redirect() -> route('posts.index');
        }else{
            abort(403, 'Unauthorized');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Post::where('id',$id)->delete();
        return redirect()->route('posts.index');
    }
}
