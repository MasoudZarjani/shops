<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\Api\v1\CategoryResource;
use App\Http\Resources\Api\v1\QuestionResource;
Use App\Helpers\UploadAdmin;

class Category extends Model
{
    use CreateUuid, SoftDeletes;
    protected $guarded = [];
    /**
     * Get the category's file.
     */
    public function file()
    {
        return $this->morphOne(File::class, 'file_able');
    }

    public function image()
    {
        return $this->file()->ofPosition(config('constants.file.position.category'))->first();
    }

    /**
     * Get the category's describes.
     */
    public function describes()
    {
        return $this->morphMany(Describe::class, 'describe_able');
    }

    /**
     * Get the category's product.
     */
    public function products()
    {
        return $this->morphMany(Product::class, 'product_able');
    }

    /**
     * Get the category's product.
     */
    public function product()
    {
        return $this->morphOne(Product::class, 'product_able');
    }

    /**
     * Get all of the categories for the children.
     */
    public function children()
    {
        return $this->hasMany(self::class, 'parent_id');
    }

    /**
     * Get the category that owns the parent.
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
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
     * Scope a query to return parent_id from category.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $parent_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfCategoryId($query, $parentId)
    {
        return $query->where('parent_id', $parentId);
    }

    /**
     * Scope a query to return uuid from product.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $uuid
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    public function scopeOfId($query, $id)
    {
        return $query->where('id', $id);
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
     * Get category information
     * 
     * @param string type
     * @return json category
     */
    public static function getParentCategory($type)
    {
        return Category::ofType($type)
            ->ofCategoryId(0)
            ->ofType(config('constants.category.type.main'))
            ->active()
            ->ordered()
            ->paginate(10);
    }

    public static function getQuestion($category)
    {
        $questions = $category->describes()->ofType(config('constants.describe.type.question'))->get();
        return QuestionResource::collection($questions ?? []);
    }

    public function getDescribe()
    {
        return $this->describes()->ofType(config('constants.describe.type.text'))->first()->title ?? "";
    }

    public static function getByOrder()
    {
        $per_page = empty(request('per_page')) ? 10 : (int) request('per_page');
        $direction = request('direction')  ?? 'asc';
        $sortBy = request('sortBy') ?? 'id';
        $parentId = request('parentId') ?? 0;
        return Category::ofCategoryId($parentId)->orderBy($sortBy, $direction)->paginate($per_page);
    }

    public static function getByFilter()
    {
        $per_page = empty(request('per_page')) ? 10 : (int) request('per_page');
        return Category::where(function ($query) {
            $query->whereHas('describes', function ($query) {
                $query->where('title', 'LIKE', '%' . request('query') . '%');
                $query->ofType(config('constants.describe.type.text'));
            });
        })
        ->ofType(config('constants.category.type.main'))
        //->active()
        ->paginate($per_page);
    }

    public function setFile($path, $size, $type, $position)
    {
        if (!$file = $this->image())
            $file = new File();
        $file->set($path, $size, $type, $position);
        return $this->file()->save($file);
    }

    public static function set(){

        $category = new Category();
        $category->sort = request('sort');
        $category->parent_id = request('parentId');
        $category->type = config("constants.category.type.main");
        $category->status = request('status');
        $category->save();

        $describe = new Describe();
        $describe->title = request('title');
        $describe->description = request('description');
        $describe->type = config("constants.describe.type.text");
        $describe->save;
        $category->describes()->save($describe);

        $uploadAdmin = new UploadAdmin();
        if ($result = $uploadAdmin->image(request('image'), 'category'))
            $category->setFile($result, 0, 0, config('constants.file.position.category'));
    }

    public static function setUpdate($id)
    {
        $category = Category::ofId($id)->first();
        $category->sort = request('sort');
        $category->status = request('status');
        $category->save();

        $describe = $category->describes()->ofType(config("constants.describe.type.text"))->first();
        $describe->title = request('title');
        $describe->description = request('description');
        $describe->save;

        
        if(strlen(request('image')) > 50){

            $uploadAdmin = new UploadAdmin();
            if ($result = $uploadAdmin->image(request('image'), 'category'))
                $category->setFile($result, 0, 0, config('constants.file.position.category'));

        }
      
    }
}
