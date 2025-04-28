<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function assigned_lead()
    {
        return $this->hasOne(LeadAssigned::class, 'lead_id', 'id');
    }
}
