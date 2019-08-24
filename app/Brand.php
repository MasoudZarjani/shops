<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
Use App\Helpers\UploadAdmin;
Use App\Describe;
Use App\File;

class Brand extends Model
{
    use CreateUuid, SoftDeletes;
    protected $guarded = [];
    public function file()
    {
        return $this->morphOne(File::class, 'file_able');
    }

    public function image()
    {
        return $this->file()->ofPosition(config('constants.file.position.avatar'))->first();
    }

    public function describe()
    {
        return $this->morphOne(Describe::class, 'describe_able');
    }

    public function scopeOfUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function scopeOfId($query, $id)
    {
        return $query->where('id', $id);
    }



    public static function getByOrder()
    {
        $per_page = empty(request('per_page')) ? 10 : (int) request('per_page');
        $direction = request('direction')  ?? 'asc';
        $sortBy = request('sortBy') ?? 'id';
        return Brand::orderBy($sortBy, $direction)->paginate($per_page);
    }

    public static function getByFilter()
    {
        $per_page = empty(request('per_page')) ? 10 : (int) request('per_page');
        return Brand::where(function ($query) {
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

        $brand = new Brand();
        $brand->status = request('status');
        $brand->save();

        $describe = new Describe();
        $describe->title = request('title');
        $describe->description = request('description');
        $describe->type = config("constants.describe.type.text");
        $describe->save();
        $brand->describe()->save($describe);

        $uploadAdmin = new UploadAdmin();
        if ($result = $uploadAdmin->image(request('image'), 'brand'))
            $brand->setFile($result, 0, 0, config('constants.file.position.avatar'));
    }

    public static function setUpdate($id)
    {
        $brand = Brand::ofId($id)->first();
        $brand->status = request('status');
        $brand->save();

        $describe = $brand->describe->ofType(config("constants.describe.type.text"))->first();
        $describe->title = request('title');
        $describe->description = request('description');
        $describe->save;

        
        if(strlen(request('image')) > 50){

            $uploadAdmin = new UploadAdmin();
            if ($result = $uploadAdmin->image(request('image'), 'brand'))
                $brand->setFile($result, 0, 0, config('constants.file.position.avatar'));

        }
      
    }
}
