<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class EventResource.
 *
 * @package App\Http\Resources
 */
class EventResource extends JsonResource
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
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'inscribed' => $this->inscribed,
            'tickets' => $this->tickets,
            'available_tickets' => $this->available_tickets,
            'assigned_tickets' => $this->assigned_tickets,
            'registrations' => $this->registrations,
            'regulation' => $this->regulation
        ];
    }
}
