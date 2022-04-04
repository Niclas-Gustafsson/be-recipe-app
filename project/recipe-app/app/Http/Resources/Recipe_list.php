<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class recipe_list extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'recipe' => $this->recipe,
            'recipe_id' => $this->recipe_id,
            'image' => $this->image,
            'user_list_id' => $this->user_list_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
