<?php

use Illuminate\Database\Seeder;
use App\Helpers\Database\Factory;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Factory::Group('other', 'otherDescription');
    }
}
