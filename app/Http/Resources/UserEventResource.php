<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UserEventResource.
 *
 * @package App\Http\Resources
 */
class UserEventResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'session' => $this->session,
            'image' => $this->image,
            'inscription_date' => $this->pivot->updated_at->toDateTimeString()
        ];
    }
}
