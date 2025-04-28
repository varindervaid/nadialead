<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LeadResource extends JsonResource
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
            'name'                  => $this->name,
            'phone'                 => $this->phone,
            'city'                  => $this->city,
            'state'                 => $this->state,
            'source'                => $this->source,
            'lead_tag'              => $this->lead_tag,
            'qualification_status'  => $this->qualification_status,
            'rating'                => $this->rating,
            'note'                  => $this->note,
            'note_strike_first'     => $this->note_strike_first,
            'action'                => $this->action,
            'status'                => $this->status,
            'start_time'            => $this->start_time,
            'lead_id'               => $this->lead_id,
            'lead_assigned'         => $this->lead_assigned ? $this->lead_assigned : 'Not Assigned',
            'client_id'             => $this->assigned_lead ? $this->assigned_lead->user_id : '',
            'client_name'           => $this->assigned_lead ? ($this->assigned_lead->user ? $this->assigned_lead->user->name : '' ) : ''
        ];
    }
}
