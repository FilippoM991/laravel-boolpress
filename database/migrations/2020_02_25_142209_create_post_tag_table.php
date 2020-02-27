<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {
            // creo colonne per gli id delle altre due tabelle,dovranno avere le stesse caratteristiche che hanno nella tabella originale,quindi in questo caso bigInteger e unsigned
            $table->bigInteger('post_id')->unsigned();
            $table->bigInteger('tag_id')->unsigned();
            $table->foreign('post_id')->references('id')->on('posts');
            $table->foreign('tag_id')->references('id')->on('tags');
            // devo creare la chiave primaria in questo caso a mano, usando la funzione primary e dovendo passare due parametri uso un array
            $table->primary(['post_id' , 'tag_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('post_tag');
    }
}
