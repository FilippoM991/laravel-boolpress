@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class="pull-left">Lista di tutti i post per la gestione admin</h1>
                <a class="btn btn-success pull-right" href="{{route('admin.posts.create')}}">Crea nuovo post</a>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <table class='table'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titolo</th>
                            <th>Slug</th>
                            <th>Autore</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>


                    @forelse ($posts as $post)
                        <tr>
                            <td>{{$post->id}}</td>
                            <td>{{$post->title}}</td>
                            <td>{{$post->slug}}</td>
                            <td>{{$post->author}}</td>
                            <td>
                                <a class='btn btn-info' href="{{route('admin.posts.show' , ['post' => $post->id])}}">Visualizza</a>
                                <a class='btn btn-warning' href="{{route('admin.posts.edit' , ['post' => $post->id])}}">Modifica</a>
                                <form class="" action="{{route('admin.posts.destroy', ['post'=> $post->id])}}" method="post">
                                @method('DELETE')
                                @csrf
                                <input class="btn btn-danger" type="submit" value="Cancella">

                                </form>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Non c'è alcun post</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


@endsection
