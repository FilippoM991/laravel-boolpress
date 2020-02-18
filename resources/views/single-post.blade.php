@extends('layouts.public')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>{{ $post->title}}</h1>
                <div class="post-content">
                    {{ $post->content }}
                </div>
                <p><em>{{ $post->author}} </em></p>
            </div>

        </div>

    </div>

@endsection
