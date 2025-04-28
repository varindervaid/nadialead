<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AssignLeadField;

class DefaultPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fields = [
            'lead_tag',
            'note',
            'qualification_status',
            'rating',
            'note_strike_first',
            'action',
            'status',
        ];
        foreach ($fields as $key => $field) {
            $role_id = 2;
            if($key > 3){
                $role_id = 3;
            }
            AssignLeadField::create([
                'role_id' => $role_id,
                'lead_assign_fields' => $field
            ]);
        }
    }
}
