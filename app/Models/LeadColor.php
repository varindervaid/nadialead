<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Role;


class LeadColor extends Model
{

    protected $guarded = ['id'];

    protected $table = "leads_colors";
    public $timestamps = false;

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

}
