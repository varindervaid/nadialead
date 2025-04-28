<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<string , mixed>
     */

    public function toArray(Request $request) : array
    {
        return [
            'id'            => $this->id,
            'name'          => ucfirst($this->name),
            'email'         => $this->email,
            'role'          => $this->roles->first()?->name
        ];
    }

}
