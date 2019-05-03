<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class NumberResource.
 *
 * @package App\Http\Resources
 */
class NumberWithUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $number = [
            'id' => $this->id,
            'value' => $this->value,
            'session' => $this->session,
            'description' => $this->description,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_id' => $this->user_id,
            'full_search' => $this->full_search
        ];
        if ( $this->user) {
            $number = array_merge($number, [
                'user' => [
                    'id' => $this->user->id,
                    'name' => $this->user->name,
                    'sn1' => $this->user->sn1,
                    'sn2' => $this->user->sn2,
                    'givenName' => $this->user->givenName,
                    'email' => $this->user->email,
                ]
            ]);
        }
        return $number;
    }
}
