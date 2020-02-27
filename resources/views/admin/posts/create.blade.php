@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h1 class='post-title'>Creazione nuovo post</h1>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form class="" action="{{route('admin.posts.store')}}" method="post" enctype='multipart/form-data'>
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name='title' value='{{old("title")}}'  placeholder="Titolo">
                  </div>
                    <div class="form-group">
                        <label for="author">Autore</label>
                        <input type="text" class="form-control" id="author" name='author' value='{{old("author")}}'  placeholder="Autore">
                  </div>
                    <div class="form-group">
                        <label for="content">Testo articolo</label>
                        <textarea id="content" placeholder="Inizia a scrivere un articolo.." class="form-control" name="content" rows="8">{{old("content")}}</textarea>

                  </div>
                  <div class="form-group">
                      <label for="cover_image_file">Immagine copertina</label>
                      <input type="file" class="form-control-file" id="cover_image_file" name='cover_image_file'>
                </div>
                @if ($categories->count() > 0 )
                    <select class="form-group" name="category_id">
                        <option value="">Seleziona la categoria</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}"
                                {{old("category_id") == $category->id ? "selected" : ''}}>
                                {{$category->name}}
                            </option>
                        @endforeach
                    </select>
                @else
                    <a href="#">Aggiungi la prima categoria</a>
                @endif
                @if ($tags->count() > 0)
                    <p>Seleziona i tag per questo post</p>
                    @foreach ($tags as $tag)
                        <label for="tag_{{$tag->id}}">
                            <input id="tag_{{$tag->id}}" type="checkbox" name="tag_id[]" value="{{$tag->id}}">
                            {{-- mettendo l id nel value lui si pesca l entità dal database, mappa da solo, nel name mi serve mettere più id quindi mi serve un array --}}
                            {{in_array($tag->id, old('tag_id' , array())) ? 'checked' : ''}}

                            {{$tag->name}}
                        </label>
                    @endforeach
                @endif


                    <div class="form-group">
                        <input type="submit" class="btn btn-primary" value="Crea">

                  </div>
                </form>
            </div>
        </div>
    </div>
@endsection
