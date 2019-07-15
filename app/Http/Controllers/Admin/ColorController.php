<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Color;
use App\Http\Resources\Admin\ColorResource;

class ColorController extends Controller
{
    public function index()
    {
        return ColorResource::collection(Color::all());
    }

    public function update()
    {
        $color = Color::find(request('id'));
        $color->set();
        $color->save();
    }
}
