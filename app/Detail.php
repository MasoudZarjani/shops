<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail extends Model
{
    protected $guarded = [];
    protected $casts = [
        'properties' => 'array'
    ];
    protected $dates = ['deleted_at']; //<--- new field to be added in your table

    use SoftDeletes;

    public function detail_able()
    {
        return $this->morphTo();
    }
    
    /**
     * Get the user that owns the detail.
     */
//    public function user()
//    {
//        return $this->belongsTo('App\User', 'id','property_id');
//    }

    /**
     * Scope a query to only include message details.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
//    public function scopeIfMessage($query)
//    {
//        return $query->where('property_type', config('constants.detail.type.message'));
//    }

    public function scopeIfProduct($query)
    {
        return $query->where('property_type', config('constants.detail.type.product'));
    }

    public function scopeOfType($query, $type)
    {
        return $query->where('property_type', config('constants.detail.type.'.$type));
    }

    public function scopeOfId($query, $id)
    {
        return $query->where('property_id', $id);
    }

    /**
     * Create detail row in database.
     *
     * @param  string $type
     * @param  integer $type_id
     */
//    public function storeFromRequest($data, $type, $property_id) {
//        $this->properties = $data;
//        $this->property_type = $type;
//        $this->property_id = $property_id;
//        $this->save();
//    }
    
    //panel send push
    public function set($data) {
        $this->properties = $data;
        $this->save();
    }
}
