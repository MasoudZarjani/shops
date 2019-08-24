<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
Use App\Helpers\UploadAdmin;

class Product extends Model
{

    use CreateUuid, SoftDeletes;

    /**
     * Get all of the owning product_able models.
     */
    public function product_able()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the tags for the product.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tag_able');
    }

    /**
     * Get all of the colors for the product.
     */
    public function colors()
    {
        return $this->morphToMany(Color::class, 'color_able');
    }

    /**
     * Get all of the prices for the product.
     */
    public function prices()
    {
        return $this->morphToMany(Price::class, 'price_able');
    }

    /**
     * Get all of the attributes for the product.
     */
    public function attributes()
    {
        return $this->morphToMany(Attribute::class, 'attribute_able');
    }

    /**
     * Get all of the groups for the product.
     */
    public function groups()
    {
        return $this->morphToMany(Group::class, 'group_able');
    }

    /**
     * Get all of the product's messages.
     */
    public function messages()
    {
        return $this->morphMany(Message::class, 'message_able');
    }

    /**
     * Get all of the product's baskets.
     */
    public function baskets()
    {
        return $this->morphMany(Basket::class, 'basket_able');
    }

    /**
     * Get all of the product's warrantors.
     */
    public function warrantors()
    {
        return $this->morphMany(Warrantor::class, 'warrantor_able');
    }

    /**
     * Get all of the product's for the files.
     */
    public function files()
    {
        return $this->morphMany(File::class, 'file_able');
    }

    /**
     * Get the product's describe.
     */
    public function describe()
    {
        return $this->morphOne(Describe::class, 'describe_able');
    }

    /**
     * Get all of the product's actions.
     */
    public function actions()
    {
        return $this->morphMany('App\Action', 'action_able');
    }

    /**
     * Get all of the product's detail.
     */
    public function detail()
    {
        return $this->morphOne(Detail::class, 'detail_able');
    }

    /**
     * Scope a query to return active from product.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $active
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive($query)
    {
        return $query->where('status', config('constants.product.status.active'));
    }

    /**
     * Scope a query to return active from product.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $active
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfId($query,$id)
    {
        return $query->where('id', $id);
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

    /**
     * Get product detail
     * 
     * @param string uuid
     * @return json product
     */
    public static function getWithUuid()
    {
        return Product::ofUuid(request('product_uuid'))->active()->first();
    }

    public static function setBookmark($user)
    {
        $product = Product::getWithUuid();
        if ($action = Action::checkBookmark($product->actions(), $user->id)) {
            $action->delete();
            return false;
        } else {
            $action = new Action();
            $action->set($user->id);
            $product->actions()->save($action);
            return true;
        }
    }

    //==========Panel

    public static function getByOrder()
    {
        $per_page = empty(request('per_page')) ? 10 : (int) request('per_page');
        $direction = request('direction')  ?? 'asc';
        $sortBy = request('sortBy') ?? 'id';
        return Product::orderBy($sortBy, $direction)->paginate($per_page);
    }

    
    public static function getByFilter()
    {
        $per_page = empty(request('per_page')) ? 10 : (int) request('per_page');
        return Product::active()->where(function ($query) {
            $query->whereHas('describe', function ($query) {
                $query->where('title', 'LIKE', '%' . request('query') . '%');
            });
        })->paginate($per_page);
    }

    public static function updateDetail()
    {
        $product = Product::ofId(request('id'))->first();
        $product->status = request('status');
        $product->brand = Describe::ofTitle(request('brand'))->first()->describe_able_id;
        $product->save();

        if(!$describe = $product->describe);
        {
            $describe = new Describe();   
        }

        $describe->type = config("constants.describe.type.text");
        $describe->title = request('title');
        $describe->description = request('description');
        $product->describe()->save($describe);

        $detail = $product->detail->properties;

        //$detail['price'] = request('price');
        //$detail['discount'] = request('discount');
        $product->detail->update([
            'properties' => $detail,
        ]);
        if(strlen(request('mainImage')) > 50){
            $uploadAdmin = new UploadAdmin();
            if ($result = $uploadAdmin->image(request('mainImage'), 'product'))
                $product->setFile($result, 0, 0, 2);//config('constants.file.position.productMainImage')
        }
    }

    
    public function setFile($path, $size, $type, $position)
    {
        if (!$file = $this->files()->where('position',2)->first())
            $file = new File();
        $file->set($path, $size, $type, $position);
        return $this->files()->save($file);
    }

}
