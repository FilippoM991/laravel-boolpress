<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable= ['title', 'author', 'content', 'slug','cover_image','category_id'];

    public function category() {
        return $this->belongsTo('App\Category');
    }
    public function tags() {
        return $this->belongsToMany('App\Tag'); //se avessi chiamato la tabella diversamente dalla struttura consigliata cioè oridine alfabetico primo nome singolare_secondo nome singolare , avrei dovuto inserire qui detro alla parentsi il nome della tabella
    }
}
