<?php

namespace App\Helpers\Database;

class Setting
{
    public static function setDescribe($title, $description, $type)
    {
        $desc = new Describe();
        $desc->title = $title;
        $desc->description = $description;
        $desc->type = config('constants.describe.type.' . $type);
        $desc->save();
    }
}
