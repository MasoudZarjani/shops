<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\CreateUuid;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use CreateUuid, SoftDeletes;

    /**
     * Get all of the owning message_able models.
     */
    public function message_able()
    {
        return $this->morphTo();
    }

    /**
     * Get all of the message's actions.
     */
    public function actions()
    {
        return $this->morphMany('App\Action', 'action_able');
    }

    /**
     * Get the message's describe.
     */
    public function describe()
    {
        return $this->morphOne(Describe::class, 'describe_able');
    }

    /**
     * Get the message's user.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * Scope a query to return type from message.
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
     * Scope a query to return user_id from messages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  mixed $user_id
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOfUser($query, $user_id)
    {
        return $query->where('user_id', $user_id);
    }

    /**
     * Scope a query to return uuid from message.
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
     * Get message information with product uuid
     */
    public static function getWithUuid()
    {
        return Message::ofUuid(request('message_uuid'))->first();
    }

    /**
     * Get message information with product uuid
     */
    public static function getWithProduct($product)
    {
        if ($product)
            return $product->messages()->paginate(config('constants.default.pagination.limited'));
        return false;
    }

    /**
     * Create message
     */
    public function set($user_id)
    {
        $product = Product::getWithUuid();

        $this->user_id = $user_id ?? 0;
        $this->type = request('type') ?? 0;
        $this->save();

        $describe = new Describe();
        $describe->set();
        $this->describe()->save($describe);

        $questions = json_decode(request('questions'));

        foreach ($questions as $question) {
            $action = new Action();
            $action->setQuestionWithJson($question, $user_id);
            $this->actions()->save($action);
        }

        $product->messages()->save($this);
        return true;
    }

    public static function checkQuestion($user_id)
    {
        if ($message = Message::ofUser($user_id)->first()) {
            if ($message->message_able->uuid == request('product_uuid'))
                return true;
        }
        return false;
    }

    public static function checkQuestionWithUuid($user_id)
    {
        if ($message = Message::ofUser($user_id)->first()) {
            if ($message->message_able)
                if ($message->message_able->uuid == request('product_uuid'))
                    return $message->uuid;
        }
        return '';
    }

    public function setMessageAction($user_id)
    {
        $actionMessage = $this->actions()->ofUserId($user_id)->ofType(request('type'))->first();
        if (!$actionMessage) {
            $action = new Action();
            $action = $action->set($user_id);
            if ($this->actions()->save($action))
                return $actionMessage;
        } else if ($actionMessage->value != request('value')) {
            $actionMessage = $actionMessage->set($user_id);
            if ($this->actions()->save($actionMessage))
                return $actionMessage;
        } else {
            $actionMessage->value = config('constants.action.likeType.nothing');
            $actionMessage->save();
            return $actionMessage;
        }
        return false;
    }
}
