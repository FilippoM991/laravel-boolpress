<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::all();
        return view('admin.posts.index', [ 'posts'=> $posts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // vado a prendermi tutte le categorie nel database e le passo alla view
        $categories = Category::all();
        return view('admin.posts.create', ['categories'=> $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // prendo quello che mi arrivata dal form
        $dati= $request->all();
        // dd($dati);
        // creo un entità e uso quello che è arrivato dal form per completarla con la funzione fill()
        $post= new Post();
        $post->fill($dati);

        if (!empty($dati['cover_image_file'])) {
            // prendo la parte che mi serve dall array
            $cover_image = $dati['cover_image_file'];
            // uso la facades Storage con la funzione put,dicendogli dove mettere il file e cosa andare a prendere(il nostro oggettone),salvo tutto dentro una variabile visto che mi viene restituito il path di cui ho bisogno,questa put parte da storage\app\public,noi gli diciamo di creare la cartella uploads
            $cover_image_path = Storage::put('uploads', $cover_image);
            // assegno a mano questa parte, il resto viene compilato da fill()
            $post->cover_image= $cover_image_path;
        }

        $slug_originale = Str::slug($dati['title']);
        $slug= $slug_originale;
        // verifico che nel db non esiste uno slug uguale
        $post_stesso_slug = Post::where('slug' , $slug)->first();
        $slug_trovati = 1;
        while (!empty($post_stesso_slug)) {
            $slug= $slug_originale . '-' . $slug_trovati;
            $post_stesso_slug = Post::where('slug' , $slug)->first();
            $slug_trovati++;
        }
        $post->slug=$slug;


        $post->save();
        return redirect()->route('admin.posts.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        // $post = Post::find($id);
        return view('admin.posts.show', ['post'=> $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post /*$id*/)
    {
        // $post = Post::find($id);
        $categories = Category::all();
        return view('admin.posts.edit', ['post'=> $post , 'categories'=> $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        // prendo quello che mi arrivata dal form
        $dati= $request->all();

        if (!empty($dati['cover_image_file'])) {
            // prendo la parte che mi serve dall array
            $cover_image = $dati['cover_image_file'];
            // uso la facades Storage con la funzione put,dicendogli dove mettere il file e cosa andare a prendere(il nostro oggettone),salvo tutto dentro una variabile visto che mi viene restituito il path di cui ho bisogno,questa put parte da storage\app\public,noi gli diciamo di creare la cartella uploads
            $cover_image_path = Storage::put('uploads', $cover_image);
            // assegno a mano questa parte, il resto viene compilato da fill()
            // abbiamo aggiunto _file al name dell imput dell immagine nei form per differenziare quello che arriva dal form con quello che deriva dall aver dato questo nome nella tabella.
            $dati['cover_image']= $cover_image_path;
        }

        // $post->fill($dati);
        // $post->save();
        // se $post contiene già i id significa che esisteva già e fa update altrimenti fa inserisci
        $post->update($dati);
        return redirect()->route('admin.posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post_image = $post->cover_image;
        Storage::delete($post_image);
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
