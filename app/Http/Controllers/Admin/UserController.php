<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\UserResource;
use App\User;

class UserController extends Controller
{
    /**
     * Get user without sorting
     * @return resource user
     */
    public function index()
    {
        $users = User::get();
        return UserResource::collection($users);
    }

    public function order()
    {
        $users = User::getByOrder();
        return UserResource::collection($users);
    }

    public function filter()
    {
        $users = User::getByFilter();
        return UserResource::collection($users);
    }

    public function delete($id)
    { }

    public function update()
    { }

    public function create()
    { }

    public function changeState($id)
    { }
}
