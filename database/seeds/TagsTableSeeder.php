<?php

use Illuminate\Database\Seeder;
use App\Helpers\Database\Factory;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Tag::class, 50)->create();
    }
}
