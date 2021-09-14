<?php

namespace Sitic\Auth\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserPasswordResetResource extends JsonResource
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
            'token' => $this->token,
            'expired_at' => strtotime($this->expired_at),
            'created_at' => strtotime($this->created_at)
        ];
    }
}
