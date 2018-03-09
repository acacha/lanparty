<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class EventResource.
 *
 * @package App\Http\Resources
 */
class EventResourceForHomePage extends JsonResource
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
            'image' => $this->image,
            'inscription_type_id' => $this->inscription_type_id,
            'available_tickets' => $this->available_tickets
        ];
    }
}
