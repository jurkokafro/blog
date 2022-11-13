<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdminPostController extends Controller
{
    public function index()
    {
        return view('admin.posts.index', [
            'posts' => Post::paginate(50)
        ]);
    }

    //Show a form to create a post
    public function create() {
        return view('admin.posts.create');
    }

    //Shrani post v bazo
    public function store() {

     $attributes = request()->validate([
         'title' => 'required',
         'thumbnail' => 'required|image',
         'slug' => ['required', Rule::unique('posts', 'slug')],
         'excerpt' => 'required',
         'body' => 'required',
         'category_id' => ['required', Rule::exists('categories','id')],
     ]);

     $attributes['user_id'] = auth()->id();
     $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');


     Post::create($attributes);

     return redirect('/');
    }

    public function edit(Post $post) {
        //show details
        return view('admin.posts.edit', ['post' => $post]);
    }

    public function update(Post $post) {

        $attributes = request()->validate([
            'title' => 'required',
            'thumbnail' => 'image',
            'slug' => ['required', Rule::unique('posts', 'slug')->ignore($post->id)],
            'excerpt' => 'required',
            'body' => 'required',
            'category_id' => ['required', Rule::exists('categories','id')],
        ]);

        if(isset($attributes['thumbnail'])) {
            $attributes['thumbnail'] = request()->file('thumbnail')->store('thumbnails');
        }


        $post->update($attributes);
        return back()->with('success', 'Vaš prispevek je uspešno posodobljen!');

    }

    public function destroy(Post $post) {
        $post->delete();

        return back()->with('success', 'Prispevek je bil uspešno izbrisan!');
    }
}
