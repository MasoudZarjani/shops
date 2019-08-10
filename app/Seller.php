<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\Api\v1\SellerResource;
use App\Traits\CreateUuid;
Use App\Helpers\UploadAdmin;

class Seller extends Model
{

    use  SoftDeletes, CreateUuid;

    protected $fillable = [
        'status'
    ];
    protected $guarded = [];

    /**
     * Get all of the products that are assigned this tag.
     */
    public function products()
    {
        return $this->morphedByMany(Product::class, 'seller_able');
    }

    
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

    public function scopeOfId($query, $id)
    {
        return $query->where('id', $id);
    }



    public static function getByOrder()
    {
        $per_page = empty(request('per_page')) ? 10 : (int) request('per_page');
        $direction = request('direction')  ?? 'asc';
        $sortBy = request('sortBy') ?? 'id';
        return Seller::orderBy($sortBy, $direction)->paginate($per_page);
    }

    public static function getByFilter()
    {
        $per_page = empty(request('per_page')) ? 10 : (int) request('per_page');
        return Seller::where(function ($query) {
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

        $seller = new Seller();
        $seller->status = request('status');
        $seller->save();

        $describe = new Describe();
        $describe->title = request('title');
        $describe->description = request('description');
        $describe->type = config("constants.describe.type.text");
        $describe->save();
        $seller->describe()->save($describe);

        $uploadAdmin = new UploadAdmin();
        if ($result = $uploadAdmin->image(request('image'), 'seller'))
            $seller->setFile($result, 0, 0, config('constants.file.position.avatar'));
    }

    public static function setUpdate($id)
    {
        $seller = Seller::ofId($id)->first();
        $seller->status = request('status');
        $seller->save();

        $describe = $seller->describe->ofType(config("constants.describe.type.text"))->first();
        $describe->title = request('title');
        $describe->description = request('description');
        $describe->save;

        
        if(strlen(request('image')) > 50){

            $uploadAdmin = new UploadAdmin();
            if ($result = $uploadAdmin->image(request('image'), 'seller'))
                $seller->setFile($result, 0, 0, config('constants.file.position.avatar'));

        }
      
    }
}
