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
        // Setting
        Factory::describe('tell', '09335551234', 'setting');
        Factory::describe('address', 'private st.', 'setting');
        Factory::describe('telegram', 'http://telegram.me/@real', 'setting');
        Factory::describe('instagram', 'http://instagram.com/real', 'setting');
        Factory::describe('email', 'admin@info.com', 'setting');

        // Group
        Factory::group('other', 'otherDescription');
        Factory::group('special', 'specialDescription');

        //Tag
        for($i = 0; $i < 15; $i++)
        {
            Factory::tag();
        }

        //Product
        for($i = 0; $i < 14; $i++)
        {
            Factory::product();
        }
    }
}
