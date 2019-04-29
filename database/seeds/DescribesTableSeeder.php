<?php

use Illuminate\Database\Seeder;
use App\Describe;
use App\Helpers\Database\Setting;

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
        Setting::setDescribe('categoryPaginationLimited', '3', 'setting');
        Setting::setDescribe('slidersShow', '1', 'setting');
        Setting::setDescribe('categoriesShow', '1', 'setting');
        Setting::setDescribe('slidersSort', '1', 'setting');
        Setting::setDescribe('categoriesSort', '2', 'setting');
    }
}
