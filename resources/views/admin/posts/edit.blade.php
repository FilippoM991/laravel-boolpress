@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class='post-title'>Creazione nuovo post</h1>
                <form class="" action="{{route('admin.posts.update', ['post' => $post->id])}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name='title' value='{{$post->title}}'>
                  </div>
                    <div class="form-group">
                        <label for="author">Autore</label>
                        <input type="text" class="form-control" id="author" value='{{$post->author}}' name='author'>
                  </div>
                    <div class="form-group">
                        <label for="content">Testo articolo</label>
                        <textarea id="content" class="form-control" name="content" rows="8">{{$post->content}}</textarea>

                  </div>
                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Aggiorna">

                  </div>
                </form>
            </div>
        </div>
    </div>
@endsection
