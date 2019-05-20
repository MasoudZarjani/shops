<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Action extends Model
{
    protected $fillable = ['user_id', 'type', 'value', 'status', 'action_able_type', 'action_able_id'];
    /**
     * Get all of the owning action_able models.
     */
    public function action_able()
    {
        return $this->morphTo();
    }

    /**
     * Get the action's describe.
     */
    public function describe()
    {
        return $this->morphOne(Describe::class, 'describe_able');
    }

    /**
     * Scope a query to return type from action.
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
     * Scope a query to return value from action.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfNotValue($query, $value)
    {
        return $query->where('value', '<>', $value);
    }

    /**
     * Scope a query to return user_id from action.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $user_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUserId($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    /**
     * Scope a query to return like from action.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeLike($query)
    {
        return $query->where('value', config('constants.action.likeType.like'));
    }

    /**
     * Scope a query to return dislike from action.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDislike($query)
    {
        return $query->where('value', config('constants.action.likeType.dislike'));
    }

    /**
     * Create action
     */
    public function set($user_id)
    {
        $this->value = request('value') ?? ($this->value ?? 0);
        $this->user_id = $user_id ?? ($this->user_id ?? 0);
        $this->describe_id = request('describe_uuid') ?? ($this->describe_id ?? 0);
        $this->type = request('type')  ?? ($this->type ?? 0);
        $this->status = config('constants.action.status.inactive');
        $this->save();
        return $this;
    }

    public static function createAndCheck($type, $model_id, $user_id)
    {
        return Action::firstOrCreate([
            'user_id' => $user_id,
            'type' => config('constants.action.type.bookmark'),
            'value' => 1,
            'status' => config('constants.action.status.active'),
            'action_able_type' => 'App\\' . $type,
            'action_able_id' => $model_id
        ]);
    }

    /**
     * Create action with json data
     */
    public function setQuestionWithJson($question, $user_id)
    {
        $describe = Describe::ofUuid($question->uuid)->first();
        $this->value = $question->count ?? 0;
        $this->user_id = $user_id ?? 0;
        $this->describe_id = $describe->id ?? 0;
        $this->type = config('constants.action.type.question');
        $this->status = config('constants.action.status.inactive');
        $this->save();
        return $this;
    }

    public static function getLikes($actions)
    {
        return $actions->ofType(config('constants.action.type.like'))->like()->count();
    }

    public static function checkLike($actions, $user_id)
    {
        return $actions->ofType(config('constants.action.type.like'))->ofUserId($user_id)->first();
    }

    public static function checkBookmark($actions, $user_id)
    {
        return $actions->ofType(config('constants.action.type.bookmark'))->ofUserId($user_id)->first();
    }

    public static function getDislikes($actions)
    {
        return $actions->ofType(config('constants.action.type.like'))->dislike()->count();
    }
}
