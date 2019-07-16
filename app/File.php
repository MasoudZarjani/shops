<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\Api\v1\FileResource;

class File extends Model
{
    use  SoftDeletes;
    protected $guarded = [];
    /**
     * Get all of the owning file_able models.
     */
    public function file_able()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the colors for the file.
     */
    public function colors()
    {
        return $this->morphToMany(Color::class, 'color_able');
    }

    /**
     * Get the file's describe.
     */
    public function describe()
    {
        return $this->morphOne(Describe::class, 'describe_able');
    }

    /**
     * Scope a query to return position from file.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $position
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfPosition($query, $position)
    {
        return $query->where('position', $position);
    }

    /**
     * Get files information
     */
    public static function get($position)
    {
        $file = File::ofPosition(config('constants.file.position.' . $position))->get();
        if (count($file) > 0) {
            return FileResource::collection($file);
        }
        return [config('constants.default.slider')];
    }

    public function set($path, $size, $type, $position)
    {
        $this->path = $path ?? "";
        $this->size = $size ?? "";
        $this->type = $type ?? 0;
        $this->position = $position ?? 0;
        return $this->save();
    }
}
