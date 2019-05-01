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
        $tags = File::get("database/data/tags.json");
        $tags = json_decode($tags);
        foreach ($tags as $tag) {
            $tagModel = new Tag();
            $tagModel->title = $tag->title;
            $tagModel->save();
        }
    }
}
