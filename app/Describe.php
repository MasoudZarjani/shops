<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\Api\v1\SettingResource;
use App\Traits\CreateUuid;

class Describe extends Model
{
    use  SoftDeletes, CreateUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description',
    ];

    /**
     * Get all of the owning describe_able models.
     */
    public function describe_able()
    {
        return $this->morphTo();
    }

    /**
     * Scope a query to return type from describe.
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
     * Scope a query to return id from describe.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfId($query, $id)
    {
        return $query->where('id', $id);
    }

    /**
     * Scope a query to return title from describe.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $title
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfTitle($query, $title)
    {
        return $query->where('title', $title);
    }

    /**
     * Scope a query to return uuid from describes.
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
     * Get setting from describe model with title
     */
    public static function getSettingWithTitle($title)
    {
        $result = Describe::ofTitle($title)->ofType(config('constants.describe.type.layoutStatus'))->first();
        return $result->description ?? 0;
    }

    /**
     * Get setting from describe model with type
     */
    public static function getSettingWithType($type)
    {
        $result = Describe::ofType($type)->get();
        return SettingResource::collection($result);
    }

    /**
     * Get all setting from describes
     */
    public static function getSetting()
    {
        return Describe::getSettingWithType(config('constants.describe.type.setting'));
    }

    /**
     * Get setting from describes
     */
    public static function getSettingIndex()
    {
        return [
            'slider' => [
                'status' => (int)Describe::getSettingWithTitle('slidersShowStatus') ?? 0,
                'sort' => (int)Describe::getSettingWithTitle('slidersSort') ?? 0,
            ],
            'categories' => [
                'status' => (int)Describe::getSettingWithTitle('categoriesShowStatus') ?? 0,
                'sort' => (int)Describe::getSettingWithTitle('categoriesSort') ?? 0,
            ],
            'specialOffer' => [
                'status' => (int)Describe::getSettingWithTitle('specialOfferShowStatus') ?? 0,
                'sort' => (int)Describe::getSettingWithTitle('specialOfferSort') ?? 0,
            ],
            'banner' => [
                'status' => (int)Describe::getSettingWithTitle('bannersShowStatus') ?? 0,
                'sort' => (int)Describe::getSettingWithTitle('bannersSort') ?? 0,
            ],
            'products' => [
                'status' => (int)Describe::getSettingWithTitle('productsShowStatus') ?? 0,
                'sort' => (int)Describe::getSettingWithTitle('productsSort') ?? 0,
            ]
        ];
    }

    /**
     * Create describe
     */
    public function set()
    {
        $this->title = request('title') ?? $this->title;
        $this->description = request('description') ?? "";
        $this->save();
        return $this;
    }
    

        /**
     * Create describe
     */
    public function setWithType($type)
    {
        $this->title = request('title') ?? "";
        $this->description = request('description') ?? "";
        $this->type = $type ?? 0;
        $this->save();
        return $this;
    }

    public static function getByOrder($type)
    {
        $per_page = empty(request('per_page')) ? 10 : (int) request('per_page');
        $direction = request('direction')  ?? 'asc';
        $sortBy = request('sortBy') ?? 'title';
        return Describe::ofType($type)->select('title','description','id')->orderBy($sortBy, $direction)->paginate($per_page);
    }

}
