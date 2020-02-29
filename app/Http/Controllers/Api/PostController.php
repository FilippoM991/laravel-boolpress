<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index() {
        $posts= Post::all();
        return response()->json([
            'success'=> true,
            'results'=>$posts
        ]);
    }
    public function show($id) {
        $post = Post::find($id);
        if ($post) {
            return response()->json(
            [
                'success'=> true,
                'results'=>$post
            ]);
        } else {
            return response()->json(
            [
                'success'=> false,
                'results'=>[],
                'error'=> "Il post con id $id non esiste"
            ]
        );
        }
    }
    public function store(Request $request) {
        $dati_post = $request->all();
        $nuovo_post = new Post();
        $nuovo_post->fill($dati_post);
        $nuovo_post->save();
        return response()->json(
         [
            'success'=> true,
            'results'=>$nuovo_post,
         ]
        );

    }
    public function update(Request $request, $id) {
        // recupero il post che l utente vuole modificare
        $post = Post::find($id);
        if ($post) {
            // se ho trovato il post
            // leggi i dati inviati tramite api
            $dati_post = $request->all();
            // aggiorno i dati del post
            $post->update($dati_post);
            return response()->json(
            [
                'success'=> true,
                'results'=>$post
            ]);
        } else {
            // se non ho trovat il post
            return response()->json(
            [
                'success'=> false,
                'results'=>[],
                'error'=> "Il post con id $id non esiste"
            ]
        );
        }

    }
    public function destroy($id) {
        // recupero il post che l utente vuole cancellare
        $post = Post::find($id);
        if ($post) {
            // se ho trovato il post
            $post->delete();

            return response()->json(
            [
                'success'=> true,
                'results'=>[]
            ]);
        } else {
            // se non ho trovat il post
            return response()->json(
            [
                'success'=> false,
                'results'=>[],
                'error'=> "Il post con id $id non esiste"
            ]
        );
        }

    }
}
