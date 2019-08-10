<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\WarrantyResource;
use App\Warrantor;
use App\Describe;

class WarrantyController extends Controller
{
    /**
     * Get user without sorting
     * @return resource user
     */
    public function index()
    {
        $warranties = Warrantor::all();
        return WarrantyResource::collection($warranties);
    }

    public function order()
    {
        $warranties = Warrantor::getByOrder();
        return WarrantyResource::collection($warranties);
    }

    public function filter()
    {
        $warranties = Warrantor::getByFilter();
        return WarrantyResource::collection($warranties);
    }

    public function create()
    {
        return Warrantor::set();
    }

    public function delete($id)
    {
        return Warrantor::ofId($id)->delete();
    }

    public function update()
    {
        return Warrantor::setUpdate(request('id'));
    }

    public function changeState($id)
    {
        $warranty = Warrantor::ofId($id)->first();
        if ($warranty->status == 1)
            $status = 0;
        else {
            $status = 1;
        }
        $warranty->update([
            'status' => $status
        ]);

        return $warranty;
    }



}
