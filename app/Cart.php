<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;

class Cart extends Model
{
    use CreateUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the basket's color.
     */
    public function color()
    {
        return $this->hasOne(Color::class, 'id', 'color_id');
    }

    /**
     * Get the basket's warrantor.
     */
    public function warrantor()
    {
        return $this->hasOne(Warrantor::class, 'id', 'warrantor_id');
    }

    /**
     * Scope a query to return uuid from baskets.
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
     * Scope a query to return color_id from baskets.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $color_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfColor($query, $color_id)
    {
        return $query->where('color_id', $color_id);
    }

    /**
     * Scope a query to return warrantor_id from baskets.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $warrantor_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfWarrantor($query, $warrantor_id)
    {
        return $query->where('warrantor_id', $warrantor_id);
    }

    public static function check($product_id, $user_id)
    {
        return Basket::ofColor(($color = Color::getWithUuid()) ? $color->id : 0)
            ->ofWarrantor(($warrantor = Warrantor::getWithUuid()) ? $warrantor->id : 0)
            ->ofUser($user_id ?? 0)
            ->where('basket_able_type', 'App\Product')
            ->where('basket_able_id', $product_id ?? 0)
            ->first();
    }

    public function set()
    {
        $this->count = request('count') ?? ($this->count ?? 1);
        $this->color_id = ($color = Color::getWithUuid()) ? $color->id : ($this->color_id ?? 0);
        $this->warrantor_id = ($warrantor = Warrantor::getWithUuid()) ? $warrantor->id : ($this->warrantor_id ?? 0);
        $this->save();
        return $this;
    }

    public static function getWithUuid()
    {
        return Basket::ofUuid(request('basket_uuid'))->first();
    }

    public static function getWithUserId($user_id)
    {
        return Basket::ofUserId($user_id)->paginate(config('constants.default.pagination.limited'));
    }
}
