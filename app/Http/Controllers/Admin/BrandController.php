<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\BrandResource;
use App\Brand;
use App\Describe;

class BrandController extends Controller
{
    /**
     * Get user without sorting
     * @return resource user
     */
    public function index()
    {
        $brands = Brand::all();
        return BrandResource::collection($brands);
    }

    public function order()
    {
        $brands = Brand::getByOrder();
        return BrandResource::collection($brands);
    }

    public function filter()
    {
        $brands = Brand::getByFilter();
        return BrandResource::collection($brands);
    }

    public function create()
    {
        return Brand::set();
    }

    public function delete($id)
    {
        return Brand::ofId($id)->delete();
    }

    public function update()
    {
        return Brand::setUpdate(request('id'));
    }

    public function changeState($id)
    {
        $brand = Brand::ofId($id)->first();
        if ($brand->status == 1)
            $status = 0;
        else {
            $status = 1;
        }
        $brand->update([
            'status' => $status
        ]);

        return $brand;
    }



}
