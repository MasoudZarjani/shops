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
        $factory = new Factory();
        // Category
        for($i = 0; $i < 6; $i++)
        {
            $factory->category();
        }

        // Setting
        $factory->describe('tell', '09335551234', 'setting');
        $factory->describe('address', 'private st.', 'setting');
        $factory->describe('telegram', 'http://telegram.me/@real', 'setting');
        $factory->describe('instagram', 'http://instagram.com/real', 'setting');
        $factory->describe('email', 'admin@info.com', 'setting');

        // Group
        $factory->group('other', 'otherDescription');
        $factory->group('special', 'specialDescription');

        // Tag
        for($i = 0; $i < 6; $i++)
        {
            $factory->tag();
        }

        // Product
        for($i = 0; $i < 6; $i++)
        {
            $factory->product();
        }
    }
}
