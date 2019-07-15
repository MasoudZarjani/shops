<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\CreateUuid;

class Color extends Model
{
    use CreateUuid, SoftDeletes;

    /**
     * Get all of the products that are assigned this color.
     */
    public function products()
    {
        return $this->morphedByMany(Product::class, 'color_able');
    }

    /**
     * Get all of the files that are assigned this color.
     */
    public function files()
    {
        return $this->morphedByMany(File::class, 'color_able');
    }

    /**
     * Get the color's baskets.
     */
    public function baskets()
    {
        return $this->hasMany(Basket::class);
    }

    /**
     * Scope a query to return uuid from colors.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $uuid
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUuid($query, $uuid)
    {
        return $query->where('uuid', $uuid);
    }

    public static function getWithUuid()
    {
        return Color::ofUuid(request('color_uuid'))->first();
    }

    public function set()
    {
        $this->name = request('name') ?? ($this->name ?? "مشکی");
        $this->code = request('code')['hex'] ?? ($this->code ?? "#000000");
        return $this->save();
    }
}
