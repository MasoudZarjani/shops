<?php

use Illuminate\Database\Seeder;
use App\Describe;

class DescribesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Describe::class, 30)->create();
    }
}
