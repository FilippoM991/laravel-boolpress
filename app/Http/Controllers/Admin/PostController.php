<?php

namespace App\Http\Controllers\Admin;

use App\Post;
use App\Category;
use App\Tag;
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
        $tags = Tag::all();
        return view('admin.posts.create', [
            'categories'=> $categories,
            'tags'=> $tags,
        ]);

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
            'title' =>'required|max:255',
            'author' =>'required|max:255',
            'content' =>'required',
            'cover_image_file' =>'image'
        ]);
        // prendo quello che mi arrivata dal form(post)
        $dati= $request->all();
        // dd($dati);
        // creo un entità(oggetto) e uso quello che è arrivato dal form per completarla con la funzione fill()
        $post= new Post();
        $post->fill($dati);

        if (!empty($dati['cover_image_file'])) {
            // prendo la parte che mi serve dall array, l utente ha caricato un immagine
            $cover_image = $dati['cover_image_file'];
            // uso la facades Storage con la funzione put,dicendogli dove mettere il file e cosa andare a prendere(il nostro oggettone),salvo tutto dentro una variabile visto che mi viene restituito il path di cui ho bisogno,questa put parte da storage\app\public,noi gli diciamo di creare la cartella uploads
            $cover_image_path = Storage::put('uploads', $cover_image);
            // assegno a mano questa parte, il resto viene compilato da fill()
            $post->cover_image= $cover_image_path;
        }
        // recupero il titolo e genero lo slug corrispondente
        $slug_originale = Str::slug($dati['title']);
        $slug= $slug_originale;
        // verifico che nel db non esiste uno slug uguale
        $post_stesso_slug = Post::where('slug' , $slug)->first();
        $slug_trovati = 1;
        // ciclo finche non trovo uno slug libero, se è falso subito non entro qui
        while (!empty($post_stesso_slug)) {
            $slug= $slug_originale . '-' . $slug_trovati;
            $post_stesso_slug = Post::where('slug' , $slug)->first();
            $slug_trovati++;
        }
        $post->slug=$slug;

        // salvo il post a db
        $post->save();
        // creo i collegamenti nella tabella ponte, solo quelli selezionati, cancello gli altri, questo con la funzione sync che è molto utile per la funzione update


        if (!empty($dati['tag_id'])) {
            // sono stati selezionati dei tag, li assegno al post
            $post->tags()->sync($dati['tag_id']);
        }
        // redirect homepage admin post
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
        $tags = Tag::all();
        return view('admin.posts.edit', [
            'post'=> $post ,
            'categories'=> $categories,
            'tags' => $tags
        ]);
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
        $request->validate([
            'title' =>'required|max:255',
            'author' =>'required|max:255',
            'content' =>'required',
            'cover_image_file' =>'image'
        ]);
        // recupero il post dal db
        // $post = Post::find($id);
        // prendo quello che mi arrivata dal form
        $dati= $request->all();

        if (!empty($dati['cover_image_file'])) {
            if (!empty($post->cover_image)) {
                // cancello l immagine precedente
                Storage::delete($post->cover_image);
            }
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
        if (!empty($dati['tag_id'])) {
            $post->tags()->sync($dati['tag_id']);
        } else  {
            $post->tags()->sync([]);
        }


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
        if (!empty($post_image)) {
            Storage::delete($post_image);
        }


        // equivale a mettere cascade delete nel database
        if ($post->tags->isNotEmpty()) {
            $post->tags()->sync([]);
        }
        $post->delete();
        return redirect()->route('admin.posts.index');
    }
}
