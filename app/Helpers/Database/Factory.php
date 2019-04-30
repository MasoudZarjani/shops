<?php

namespace App\Helpers\Database;

use Faker\Factory as Faker;
use App\Product;
use App\Group;
use App\Describe;
use Illuminate\Http\Request;

class Factory
{
    protected $faker;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->faker = Faker::create();
    }

    public static function Group($title, $description)
    {
        $group = Group::set();
    
        $describe = Describe::setFactory($title, $description);

        $group->describe->save($describe);
    }

    public function Product()
    {
        $product = new Product();
        $product->group_id = Group::all()->random()->id;
        $product->save();
    }
}
