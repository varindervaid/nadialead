<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Log;

class RoleResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        try {
            $assignedFields = $this->assigned_column()->get()->pluck('lead_assign_fields')->toArray();

            if (empty($assignedFields)) {
                $assignedFields = [];
            }

        } catch (\Exception $e) {
            Log::error('Error retrieving assigned fields for role ID ' . $this->id . ': ' . $e->getMessage());
            $assignedFields = [];
        }
        return [
            'id'              => $this->id,
            'name'            => ucfirst($this->name),
            'assigned_fields' => $assignedFields,
        ];
    }
}
