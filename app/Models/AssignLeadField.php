<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
class AssignLeadField extends Model
{
    protected $fillable = [
        'role_id',
        'lead_assign_fields'
    ];


    // protected function leadAssignFields(): Attribute
    // {
    //     return Attribute::make(
    //         get: fn(string $value) => unserialize($value),
    //         set: fn($value) => serialize($value)
    //     );
    // }

    public function getAssignFields(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id', 'id')->where('role_id', Auth::user()->roles->first()?->id);
    }
}
