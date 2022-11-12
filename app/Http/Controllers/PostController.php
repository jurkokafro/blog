<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class PostController extends Controller
{
    public function index() {



        return view('posts.index', [

            'posts' => Post::latest()->filter(
                request(['search','category','author']))
            ->paginate()->withQueryString(),


        ]);
    }

    public function show(Post $post) {
         //Find a post by its slug and pass it to a view called post
        return view('posts.show', [
            //'post' => Post::findOrFail($id)

            'post' => $post,
        ]);
    }


    //Show a form to create a post
    public function create() {
       return view('posts.create');
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

}
