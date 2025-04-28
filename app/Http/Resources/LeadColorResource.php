<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadColorResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<string , mixed>
     */

    public function toArray(Request $request): array
    {

        return [
            'id'                    => $this->id,
            'column_key'            => $this->column_key,
            'column_key_val'        => $this->column_key ? str_replace('_',' ',ucwords($this->column_key)) : '',
            'color'                 => $this->color,
            'role_id'               => $this->role_id,
            'role_val'              => $this->role ? ucfirst($this->role->name) : '',
        ];
    }
}
