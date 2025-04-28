<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Enums\UserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Arr;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guarded = ['id'];
    protected $appends = ['status_label'];
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'created_at',
        'updated_at'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => UserStatus::class
        ];
    }

    public function getStatusLabelAttribute()
    {
        if(!$this->status) {
            return '';
        }
        return $this->status->label();
    }
    public static function user_assigned_lead_fields($roles)
    {
        $role = $roles->first();
        if($role->name == 'admin'){
            $columns = Schema::getColumnListing('leads');
            return array_keys(Arr::except(array_flip($columns), ['created_at', 'updated_at', 'id']));
        }
        return AssignLeadField::where('role_id', $role->id)->pluck('lead_assign_fields')->toArray();
    }

}
