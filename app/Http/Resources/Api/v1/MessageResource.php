<?php

namespace App\Http\Resources\Api\v1;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Product;
use App\Describe;
use App\Action;
use App\User;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $user_id = 0;
        if (request('uuid') && request('api_token'))
            $user_id = User::getWithRequest()->id;

        $product = Product::getWithUuid()->product_able;
        $actions = $this->actions->map(function ($item) use ($product) {
            $describe = Describe::ofId($item->describe_id)->first();
            $checkParent = self::checkParent($product, $describe->describe_able ?? 0, $item->describe_id);
            $count = 0;
            if (Describe::ofId($checkParent)->first())
                $count = (int)Describe::ofId($checkParent)->first()->description ?? "";
            return [
                'value' => $item->value ?? "",
                'title' => Describe::ofId($checkParent)->first()->title ?? "",
                'count' => $count,
            ];
        });

        if ($this->user->profile) {
            $name = $this->user->profile->name . ' ' . $this->user->profile->family;
            if ($this->user->file)
                $avatar = $this->user->file->path;
        }

        return [
            'uuid' => $this->uuid,
            'title' => $this->describe->title ?? "",
            'description' => $this->describe->description ?? "",
            'actions' => $actions,
            'like' => Action::getLikes($this->actions()) ?? 0,
            'like_status' => (Action::checkLike($this->actions(), $user_id)) ? 1 : 0,
            'dislike' => Action::getDislikes($this->actions()) ?? 0,
            'name' => $name ?? '',
            'avatar' => $avatar ?? ''
        ];
    }

    public function checkParent($product, $category, $describe_id)
    {
        if ($category) {
            if ($product->id == $category->id) {
                return $describe_id;
            } else if ($product->parent) {
                return self::checkParent($product->parent, $category, $describe_id);
            } else {
                return 0;
            }
        }
        return 0;
    }
}
