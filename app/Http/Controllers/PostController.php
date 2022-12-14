<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
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
}
