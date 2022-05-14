<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $user = User::find($this->user_id);
        return [
            'id' => $this->id,
            'user' => (object) array('id' => $user->id, 'name' => $user->name),
            'comment' => $this->comment,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,

        ];
    }
}
