@extends('layouts.public')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1>Lista pubblica posts</h1>
                <ul>
                    @forelse ($posts as $post)
                        <li><a href="{{ route('blog.show', ['slug' => $post->slug ])}}">{{$post->title}}</a></li>
                    @empty
                        <li>Non ci sono ancora post</li>
                    @endforelse
                </ul>
                {{-- per fare la paginazione,i numeri delle pagine --}}
                {{-- {{$posts->links()}} --}}
            </div>

        </div>

    </div>

@endsection
