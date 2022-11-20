<?php

namespace App\Http\Controllers;

use App\Contracts\CounterContract;
use App\Events\BlogPostPosted;
use App\Facades\CounterFacade;
use App\Models\BlogPost;
use App\Http\Requests\StorePost;
use App\Models\Image;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostsController extends Controller
{

    private $counter;
    public function __construct()
    // public function __construct(CounterContract $counter)
    {
        $this->middleware('auth')
            ->only(['create', 'destroy', 'store', 'edit', 'update']);

        // $this->counter = $counter;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view(
            'posts.index', 
            [
                'posts' => BlogPost::latestWithRelations()->get(),
            ]
        );
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
    public function store(StorePost $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $post = BlogPost::create($validated);

        if($request->hasFile('thumbnail')){
            $path = $request->file('thumbnail')->store('thumbnails');
            $post->image()->save(Image::make(['path'=>$path]));
        }

        event(new BlogPostPosted($post));

        $request->session()->flash('status', 'The blog post was created!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $blogPost = Cache::tags(['blog-post'])->remember("blog-post-{$id}", 60, function() use($id){
            return BlogPost::with('comments', 'tags', 'user', 'comments.user')->findOrFail($id);
        });

        // dd($blogPost->comments);
        return view('posts.show', ['post' => $blogPost, 'counter' => CounterFacade::increment("blog-post-{$id}", ['blog-post'])]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = BlogPost::findOrFail($id);

        $this->authorize($post); 

        return view('posts.edit', ['post' => $post]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StorePost $request, $id)
    {
        $post = BlogPost::findOrFail($id);
        //user is passed automatically
        $this->authorize($post);
        if($request->hasFile('thumbnail')){
            $path = $request->file('thumbnail')->store('thumbnails');
            if($post->image){
                Storage::delete($post->image->path);
                $post->image->path = $path;
                $post->image->save();
            }else {
                $post->image()->save(
                    Image::make(['path'=>$path])
                );
            }
        }
        $validated = $request->validated();
        $post->fill($validated);
        $post->save();

        $request->session()->flash('status', 'The blog post was updated!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = BlogPost::findOrFail($id);
        $this->authorize($post);

        $post->delete();

        session()->flash('status', 'The blog post was deleted! postId: '. $post->id);
        return redirect()->route('posts.index');
    }
}
