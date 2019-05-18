<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;

class Basket extends Model
{
    use CreateUuid;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['color_id', 'user_id', 'warrantor_id', 'basket_able_id', 'basket_able_type'];

    /**
     * Get all of the owning basket_able models.
     */
    public function basket_able()
    {
        return $this->morphTo();
    }

    /**
     * Get the basket's user.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

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
     * Scope a query to return user_id from baskets.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $user_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUserId($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    public static function add($product_id, $user_id)
    {
        return Basket::firstOrCreate([
            'color_id' => Color::getWithUuid(),
            'warrantor_id' => Warrantor::getWithUuid(),
            'user_id' => $user_id,
            'basket_able_id' => $product_id,
            'basket_able_type' => 'App\Product',
        ]);
    }

    public function set($user_id)
    {
        $this->count = request('count') ?? ($this->count ?? 1);
        $this->color_id = Color::getWithUuid() ?? ($this->color_id ?? 0);
        $this->user_id = $user_id ?? ($this->user_id ?? 0);
        $this->warrantor_id = Warrantor::getWithUuid() ?? ($this->warrantor_id ?? 0);
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
