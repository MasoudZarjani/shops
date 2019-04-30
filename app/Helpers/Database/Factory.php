<?php

namespace App\Helpers\Database;

use Faker\Factory as Faker;
use App\Product;
use App\Group;
use App\Describe;
use App\Tag;

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

    public static function group($title, $description)
    {
        $describes = self::describe($title, $description, 'text');
        if (!$describes->describe_able) {
            $group = Group::set();
            $group->describe()->save($describes);
        }
    }

    public static function product()
    {
        $product = new Product();
        $product->set();
    }

    public static function tag()
    {
        $tag = new Tag();
        $faker = new Factory();
        $tag->set($faker->getFaker('word'));
    }

    public static function describe($title, $description, $type)
    {
        return Describe::firstOrCreate(
            ['title' => $title],
            ['description' => $description, 'type' => config('constants.describe.type.' . $type)]
        );
    }

    public function getFaker($type)
    {
        $faker = "";
        switch ($type) {
            case 'title':
                $faker = $this->faker->realText(50);
                break;
            case 'word':
                $faker = $this->faker->unique()->word;
                break;
            case 'description':
                $faker = $this->faker->realText(1000);
                break;
            case 'image':
                $faker = $this->faker->imageUrl(150, 120, 'business');
                break;
            case 'status':
                $faker = $this->faker->numberBetween(0, 1);
                break;
            case 'size':
                $faker = $this->faker->numberBetween(100000, 99999999);
                break;
            case 'number':
                $faker = $this->faker->numberBetween(1, 5);
                break;
            default:
                break;
        }

        return $faker;
    }
}
