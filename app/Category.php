<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\Api\v1\CategoryResource;

class Category extends Model
{
    use CreateUuid, SoftDeletes;

    /**
     * Get the category's image.
     */
    public function file()
    {
        return $this->morphOne('App\File', 'file_able');
    }

    /**
     * Get the category's describe.
     */
    public function describe()
    {
        return $this->morphOne('App\Describe', 'describe_able');
    }

    /**
     * Get all of the categories for the children.
     */
    public function children()
    {
        return $this->hasMany('App\Category', 'category_id');
    }

    /**
     * Get the category that owns the parent.
     */
    public function parent()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    /**
     * Scope a query to return type from category.
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
     * Scope a query to return category_id from category.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $category_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfCategoryId($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope a query to return active from category.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $active
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', config('constants.category.status.active'));
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort', 'asc');
    }

    /**
     * Get category info
     * 
     * @param string type
     * @return json category
     */
    public static function getParentCategory($type)
    {
        $parentCategory = Category::ofType($type)->ofCategoryId(0)->active()->ordered()->get();
        return CategoryResource::collection($parentCategory);
    }
}
