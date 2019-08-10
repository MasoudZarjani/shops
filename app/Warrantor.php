<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreateUuid;
Use App\Helpers\UploadAdmin;

class Warrantor extends Model
{
    use CreateUuid, SoftDeletes;
    protected $guarded = [];
    /**
     * Get all of the owning warrantor_able models.
     */
    public function warrantor_able()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the prices for the warrantor.
     */
    public function prices()
    {
        return $this->morphToMany(Price::class, 'price_able');
    }

    /**
     * Get the warranty's baskets.
     */
    public function baskets()
    {
        return $this->hasMany(Basket::class);
    }


     /**
     * Get the warranty's description.
     */

    public function describe()
    {
        return $this->morphOne(Describe::class, 'describe_able');
    }

    /**
     * Get the warranty's image.
     */

    public function file()
    {
        return $this->morphOne(File::class, 'file_able');
    }

    public function image()
    {
        return $this->file()->ofPosition(config('constants.file.position.avatar'))->first();
    }

    /**
     * Scope a query to return uuid from warrantors.
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

    public static function getWithUuid()
    {
        return Warrantor::ofUuid(request('warrantor_uuid'))->first();
    }
    


    public static function getByOrder()
    {
        $per_page = empty(request('per_page')) ? 10 : (int) request('per_page');
        $direction = request('direction')  ?? 'asc';
        $sortBy = request('sortBy') ?? 'id';
        return Warrantor::orderBy($sortBy, $direction)->paginate($per_page);
    }

    public static function getByFilter()
    {
        $per_page = empty(request('per_page')) ? 10 : (int) request('per_page');
        return Warrantor::where(function ($query) {
            $query->whereHas('describe', function ($query) {
                $query->where('title', 'LIKE', '%' . request('query') . '%');
                $query->ofType(config('constants.describe.type.text'));
            });
        })
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

        $warranty = new Warrantor();
        $warranty->status = request('status');
        $warranty->save();

        $describe = new Describe();
        $describe->title = request('title');
        $describe->description = request('description');
        $describe->type = config("constants.describe.type.text");
        $describe->save();
        $warranty->describe()->save($describe);

        $uploadAdmin = new UploadAdmin();
        if ($result = $uploadAdmin->image(request('image'), 'warranty'))
            $warranty->setFile($result, 0, 0, config('constants.file.position.avatar'));
    }

    public static function setUpdate($id)
    {
        $warranty = Warrantor::ofId($id)->first();
        $warranty->status = request('status');
        $warranty->save();

        $describe = $warranty->describe->ofType(config("constants.describe.type.text"))->first();
        $describe->title = request('title');
        $describe->description = request('description');
        $describe->save;

        
        if(strlen(request('image')) > 50){

            $uploadAdmin = new UploadAdmin();
            if ($result = $uploadAdmin->image(request('image'), 'warranty'))
                $warranty->setFile($result, 0, 0, config('constants.file.position.avatar'));

        }
      
    }
}
