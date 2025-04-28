<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\AssignLeadField;
class LeadUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // You can add authorization logic here if needed
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'start_time' => 'nullable|date',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'source' => 'nullable|string|max:255',
            'lead_tag' => 'nullable|string|max:255',
            'qualification_status' => 'nullable|integer',
            'rating' => 'nullable|string|max:255',
            'note' => 'nullable|string',
            'note_strike_first' => 'nullable|string|max:255',
            'action' => 'nullable|string|max:255',
            'status' => 'required|string|max:255',
            'lead_id' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'start_time.date' => 'The start time must be a valid date.',
            'name.required' => 'The name field is required.',
            'name.string' => 'The name must be a string.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'phone.required' => 'The phone field is required.',
            'phone.string' => 'The phone must be a string.',
            'phone.max' => 'The phone may not be greater than 255 characters.',
            'city.required' => 'The city field is required.',
            'city.string' => 'The city must be a string.',
            'city.max' => 'The city may not be greater than 255 characters.',
            'state.required' => 'The state field is required.',
            'state.string' => 'The state must be a string.',
            'state.max' => 'The state may not be greater than 255 characters.',
            'source.string' => 'The source must be a string.',
            'source.max' => 'The source may not be greater than 255 characters.',
            'lead_tag.string' => 'The lead tag must be a string.',
            'lead_tag.max' => 'The lead tag may not be greater than 255 characters.',
            'qualification_status.integer' => 'The qualification status must be an integer.',
            'rating.string' => 'The rating must be a string.',
            'rating.max' => 'The rating may not be greater than 255 characters.',
            'note.string' => 'The note must be a string.',
            'note_strike_first.string' => 'The note strike first must be a string.',
            'note_strike_first.max' => 'The note strike first may not be greater than 255 characters.',
            'action.string' => 'The action must be a string.',
            'action.max' => 'The action may not be greater than 255 characters.',
            'status.required' => 'The status field is required.',
            'status.string' => 'The status must be a string.',
            'status.max' => 'The status may not be greater than 255 characters.',
            'lead_id.required' => 'The lead ID field is required.',
            'lead_id.string' => 'The lead ID must be a string.',
            'lead_id.max' => 'The lead ID may not be greater than 255 characters.',
        ];
    }

    /**
     * Filter the input data based on the user's role.
     *
     * @return array
     */
    public function filteredData(): array
    {
        $inputs = $this->all();
        $userRole = Auth::user()->roles->first();        
        $userRoleId = $userRole?->id;
        if ($userRole?->name === 'client') {
            $fields = $this->getEditableFieldsByRoleId($userRoleId);
            if($fields){
                return $this->only($fields);
            }
            return $this->only('action', 'status', 'note_strike_first');
        } elseif ($userRole === 'team') {
            $fields = $this->getEditableFieldsByRoleId($userRoleId);
            if($fields){
                return $this->only($fields);
            }
            return $this->only('lead_tag', 'qualification_status', 'rating', 'note');
        }
        return $inputs;
    }


    public function getEditableFieldsByRoleId($roleId){
        return AssignLeadField::where('role_id', $roleId)->pluck('lead_assign_fields')->toarray();
    }
}
