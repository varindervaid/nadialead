<?php

namespace App\Services;

use App\Models\AssignLeadField;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;

class  leadAssignService
{
    public function getFields($roleId)
    {
        try {
            $columns = Schema::getColumnListing('leads');
            $removeTeamFields = [
                'lead_tag',
                'note',
                'qualification_status',
                'rating',
            ];
            $removeClientFields = [
                'note_strike_first',
                'action',
                'status',
            ];
            $removeColumn = ['created_at', 'updated_at', 'id'];
            if ($roleId == 2) {
                $removeColumn = array_merge($removeTeamFields, $removeColumn);
            } else {
                $removeColumn = array_merge($removeClientFields, $removeColumn);
            }
            $columnsFields = array_keys(Arr::except(array_flip($columns), $removeColumn));
            if (is_array($columns)) {
                return ApiResponse::success($columnsFields);
            }
            return ApiResponse::error('Data not found', 204);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    public function getAssignFields($roleId)
    {
        try {
            $getAssignColumn = AssignLeadField::where('role_id', $roleId)->pluck('lead_assign_fields')->toarray();
            if ($getAssignColumn) {
                return ApiResponse::success($getAssignColumn);
            }
            return ApiResponse::success('Data not found', 204);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    public function assignFields($request)
    {
        try {
            AssignLeadField::where('role_id', $request->roleId)->delete();
            foreach ($request->leadAssignFields as $fields) {
                AssignLeadField::create(
                    [
                        'role_id' => $request->roleId,
                        'lead_assign_fields' => $fields,
                    ]
                );
            }
            return ApiResponse::success('Permission added successfully', 201);
        } catch (\Exception $e) {
            return ApiResponse::error($e->getMessage(), 500);
        }
    }

    public function isRequestHaveData($request){
        if(count($request->leadAssignFields) == 0){
            $teamFields = [
                'lead_tag',
                'note',
                'qualification_status',
                'rating',
            ];
            $clientFields = [
                'note_strike_first',
                'action',
                'status',
            ];
            $defaultFields = ($request->roleId == 2) ? $teamFields : $clientFields;
            AssignLeadField::where('role_id', $request->roleId)
            ->whereNotIn('lead_assign_fields', $defaultFields)
            ->delete();
            return;
        }
        AssignLeadField::where('role_id', $request->roleId)
        ->delete();
        return;
    }
}
