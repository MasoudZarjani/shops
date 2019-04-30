<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Describe extends Model
{
    use  SoftDeletes;

    /**
     * Get all of the owning describe_able models.
     */
    public function describe_able()
    {
        return $this->morphTo();
    }

    /**
     * Scope a query to return type from describe.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $type
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfType($query, $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Scope a query to return title from describe.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $title
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfTitle($query, $title)
    {
        return $query->where('title', $title);
    }

    public static function getSettingWithTitle($title)
    {
        $result = Describe::ofTitle($title)->ofType(config('constants.describe.type.setting'))->first();
        return $result->description ?? 0;
    }

    public static function getSettingIndex()
    {
        return [
            'slider' => [
                'status' => (int)Describe::getSettingWithTitle('slidersShowStatus') ?? 0,
                'sort' => (int)Describe::getSettingWithTitle('slidersSort') ?? 0,
            ],
            'categories' => [
                'status' => (int)Describe::getSettingWithTitle('categoriesShowStatus') ?? 0,
                'sort' => (int)Describe::getSettingWithTitle('categoriesSort') ?? 0,
            ],
            'specialOffer' => [
                'status' => (int)Describe::getSettingWithTitle('specialOfferShowStatus') ?? 0,
                'sort' => (int)Describe::getSettingWithTitle('specialOfferSort') ?? 0,
            ]
        ];
    }

    public static function setFactory($title, $description)
    {
        $describe = new Describe();
        $describe->title = $title ?? '';
        $describe->description = $description ?? '';
        $describe->type = config('constants.describe.type.text') ?? 0;
        $describe->save();
        return $describe;
    }
}
