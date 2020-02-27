<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = config('tags.tag_db');
        foreach ($tags as $tag) {
            $nuovo_tag = new Tag();
            // $nuovo_tag->name = $tag['name'];
            // $nuovo_tag->slug = $tag['slug'];

            $nuovo_tag->fill($tag);
            $nuovo_tag->save();

        }
    }
}
