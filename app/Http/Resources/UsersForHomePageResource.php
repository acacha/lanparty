<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class UsersForHomePageResource.
 *
 * @package App\Http\Resources
 */
class UsersForHomePageResource extends JsonResource
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
            'givenName' => $this->givenName,
            'sn1' => $this->sn1,
            'sn2' => $this->sn2,
            'formatted_created_at_date' => $this->formatted_created_at_date,
            'full_search' => $this->full_search,
            'email' => $this->email,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
