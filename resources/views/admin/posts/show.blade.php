@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class='post-title'>{{$post->title}}</h1>
                {{-- ternario classico, se l utente ha inserito un immagine metto la path di quella altrimenti uso la path di una immagine che ho gia --}}
                <img src="{{ $post->cover_image ?  asset('storage/' . $post->cover_image) : asset('images/copertina-non-disponibile.jpg') }}" alt="">
                <div class="post-content">
                    {{$post->content}}
                </div>
                <p>Autore: {{ $post->author }}</p>
                <p>Categoria: {{$post->category ? $post->category->name : '-'}}</p>
                <p>Slug: {{ $post->slug }}</p>
                <p>Creato il: {{ $post->created_at }}</p>
                <p>Modificato il: {{ $post->updated_at }}</p>
            </div>
        </div>
    </div>
@endsection
