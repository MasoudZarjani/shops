<?php

use Illuminate\Database\Seeder;
use App\Helpers\Database\Factory;

class DescribesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Factory::describe('tell', '09335551234', 'setting');
        Factory::describe('address', 'private st.', 'setting');
        Factory::describe('telegram', 'http://telegram.me/@real', 'setting');
        Factory::describe('instagram', 'http://instagram.com/real', 'setting');
        Factory::describe('email', 'admin@info.com', 'setting');
        Factory::describe('categoryPaginationLimited', '3', 'setting');
        Factory::describe('slidersShowStatus', '1', 'setting');
        Factory::describe('slidersSort', '1', 'setting');
        Factory::describe('categoriesShowStatus', '1', 'setting');
        Factory::describe('categoriesSort', '2', 'setting');
        Factory::describe('specialOfferShowStatus', '1', 'setting');
        Factory::describe('specialOfferSort', '3', 'setting');

        Factory::group('gp_other', 'otherDescription');
        Factory::group('gp_special', 'specialDescription');

        factory(App\Describe::class, 50)->create();
    }
}
