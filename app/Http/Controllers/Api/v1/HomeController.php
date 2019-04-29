<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;

class HomeController extends Controller
{
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
        return Category::getParentCategory(config('constants.category.type.main'));
    }

    public function handleErrors()
    {
        return Errors::showResponse(config('constants.error.http.' . request('error')));
    }
}
