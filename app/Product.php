<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Helpers\Database\Factory;
use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use CreateUuid, SoftDeletes;

    /**
     * Get all of the tags for the product.
     */
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'tag_able');
    }

    /**
     * Get all of the groups for the product.
     */
    public function groups()
    {
        return $this->morphToMany(Group::class, 'group_able');
    }

    /**
     * Get all of the files for the product.
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

    public function set()
    {
        $factory = new Factory();

        $this->status = $factory->getFaker('status');
        $this->save();

        $describe = $factory->describe($factory->getFaker('title'), $factory->getFaker('description'), 'text');

        $file = new File();
        $file = $file->set(
            $factory->getFaker('image'),
            $factory->getFaker('size'),
            config('constants.file.type.image'),
            config('constants.file.position.mainImage')
        );


        $group = Group::find($factory->getFaker('between'));

        $tag = Tag::find($factory->getFaker('number'));

        $this->tags()->save($tag);
        $this->groups()->save($group);
        $this->files()->save($file);
        $this->describe()->save($describe);
    }
}
