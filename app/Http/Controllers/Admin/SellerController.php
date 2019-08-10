<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\SellerResource;
use App\Seller;
use App\Describe;


class SellerController extends Controller
{
    /**
     * Get user without sorting
     * @return resource user
     */
    public function index()
    {
        $sellers = Seller::all();
        return SellerResource::collection($sellers);
    }

    public function order()
    {
        $sellers = Seller::getByOrder();
        return SellerResource::collection($sellers);
    }

    public function filter()
    {
        $sellers = Seller::getByFilter();
        return SellerResource::collection($sellers);
    }

    public function create()
    {
        return Seller::set();
    }

    public function delete($id)
    {
        return Seller::ofId($id)->delete();
    }

    public function update()
    {
        return Seller::setUpdate(request('id'));
    }

    public function changeState($id)
    {
        $seller = Seller::ofId($id)->first();
        if ($seller->status == 1)
            $status = 0;
        else {
            $status = 1;
        }
        $seller->update([
            'status' => $status
        ]);

        return $seller;
    }



}
