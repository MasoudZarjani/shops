<?php

namespace App\Helpers;

class Relations
{
    public static function morph($table, $name)
    {
        $table->string($name . '_able_type', 64)->nullable();
        $table->integer($name . '_able_id')->unsigned()->nullable();
    }


    public static function pointer($table, $name)
    {
        $table->integer($name . '_id')->unsigned()->nullable();
    }


    public static function constant($table, $name, $default)
    {
        $table->tinyInteger($name)->default(config('constants.' . $default));
    }
}