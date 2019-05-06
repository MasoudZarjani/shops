<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Category;
use App\File;
use App\Describe;
use App\Group;
use App\Http\Resources\Api\v1\ProductResource;

class HomeController extends Controller
{
    protected $user;

    /**
     * Instantiate a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        if (request('uuid') && request('api_token')) {
            $this->user = User::ofUuid(request('uuid'))->ofApiToken(request('api_token'))->first();
        }
    }

    public function index()
    {
        $mainPageData = Describe::getSettingIndex();

        $categoryPaginationLimited = (int)Describe::getSettingWithTitle('categoryPaginationLimited');
        $mainCategories = Category::getParentCategory(config('constants.category.type.main'))->take($categoryPaginationLimited);

        $specialTitles = Group::ofGroupId(0)->get();
        foreach ($specialTitles as $specialTitle) {
            if ($specialTitle->describe->title == 'gp_special')
                $specialGroup = $specialTitle;
        }

        $specialProduct = $specialGroup->products()->active()->get();
        $specialProduct = ProductResource::collection($specialProduct);

        $slider = File::get('mainSlider');

        return response()->json([
            'data' => $mainPageData,
            'categories' => $mainCategories,
            'slider' => $slider,
            'specialProduct' => $specialProduct
        ]);
    }

    public function handleErrors()
    {
        return response()->json('Unauthorized', 401);;
    }
}
