<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

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
        return Action::create('Product', $product->id, $user->id);
    }
}
