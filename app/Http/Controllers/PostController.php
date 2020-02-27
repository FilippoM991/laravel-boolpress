<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;
use App\Tag;

class PostController extends Controller
{
    public function index(){
        $posts= Post::all();
        // ne prende tre per pagina
        // $posts= Post::paginate(3);
        // exit;
        return view('posts', ['posts'=> $posts]);
    }
    public function show($slug){

        $post= Post::where('slug', $slug)->first();
        if (!empty($post)) {
            return view('single-post', ['post'=> $post]);
        } else {
            return abort(404);
        }

    }
    public function postCategoria($slug){
        // prendo lo slug che c è nell url, questo deve essere lo slug di una categoria, pigliati quella giusta, e di questa beccati tutti i post
        $categoria = Category::where('slug', $slug)->first();
        if (!empty($categoria)) {
            // posso usare la funzione che ho nel model category
            $post_categoria = $categoria->posts;
            // dd($post_categoria);
            return view('single-category', [
                'posts'=> $post_categoria,
                'category'=> $categoria
            ]);
        } else {
            return abort(404);
        }
    }
    public function postTag($slug){
        // prendo lo slug che c è nell url, questo deve essere lo slug di una categoria, pigliati quella giusta, e di questa beccati tutti i post
        $tag = Tag::where('slug', $slug)->first();
        if (!empty($tag)) {
            // posso usare la funzione che ho nel model category
            $post_tag = $tag->posts;
            // dd($post_categoria);
            return view('single-tag', [
                'posts'=> $post_tag,
                'tag'=> $tag
            ]);
        } else {
            return abort(404);
        }




    }
}
