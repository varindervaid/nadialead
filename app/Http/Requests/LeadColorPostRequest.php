<?php

namespace App\Http\Requests;

use App\Models\Lead;
use App\Models\LeadColor;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;
use Spatie\Permission\Models\Role;

class LeadColorPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        $id = $this->route('id');

        $arr = [
            'color' => ['required'],
            'role' => ['required', 'array', Rule::in($this->roles())],
        ];

        if(!$id) { # On create new color
            $arr['column_key'] = ['required',Rule::in($this->getLeadColumns()), Rule::unique(LeadColor::class)];
        }
        dd($arr);
        return $arr;
    }

    private function getLeadColumns()
    {
        $columns = $columns = Schema::getColumnListing((new Lead())->getTable());
        return $columns;
    }

    public function roles()
    {
        $roles = Role::select('id')->get();

        if($roles->count()) {
            return $roles->map(fn ($item) => $item->id)->toArray();
        } else {
            return [];
        }
    }
}
