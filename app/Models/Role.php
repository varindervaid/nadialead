<?php

namespace App\Models;

use Spatie\Permission\Models\Role as ModelsRole;

class Role extends ModelsRole
{

    public function assigned_column()
    {
        return $this->hasMany(AssignLeadField::class, 'role_id', 'id');
    }

}
