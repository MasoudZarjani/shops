<?php

namespace App\Helpers;

class Relation
{
    public static function morph($table, $name)
    {
        $table->string($name . '_able_type', 64)->nullable();
        $table->integer($name . '_able_id')->unsigned()->nullable();
    }

    public static function pointer($table, $name)
    {
        $table->bigInteger($name . '_id')->unsigned()->nullable();
    }

    public static function Foreign($table, $name, $referenceTable)
    {
        $table->foreign($name . '_id')->references('id')->on($referenceTable)->onDelete('cascade')->onUpdate('cascade');
    }

    public static function constant($table, $name, $default)
    {
        $table->tinyInteger($name)->default(config('constants.' . $default));
    }

    public static function status($table, $name, $default)
    {
        $table->boolean($name)->default(config('constants.' . $default));
    }
}
