<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Category;
use App\File;
use App\Describe;
use App\Group;
use App\User;
use App\Http\Resources\Api\v1\ProductResource;
use App\Http\Resources\Api\v1\CategoryResource;

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

        $mainCategories = CategoryResource::collection($mainCategories);

        $specialTitles = Group::ofGroupId(0)->get();
        foreach ($specialTitles as $specialTitle) {
            if ($specialTitle->describe->title == 'gp_special')
                $specialGroup = $specialTitle;
        }

        $specialProduct = $specialGroup->products()->active()->get();
        $specialProduct = ProductResource::collection($specialProduct);

        $slider = File::get('mainSlider');

        $setting = Describe::getSetting();

        return response()->json([
            'setting' => $setting,
            'data' => $mainPageData,
            'categories' => $mainCategories,
            'slider' => $slider,
            'banner' => config('constants.default.slider'),
            'specialProduct' => $specialProduct,
            'products' => $specialProduct
        ]);
    }

    public function handleErrors()
    {
        return response()->json('Unauthorized', 401);;
    }
}
