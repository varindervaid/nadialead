<?php

namespace App\Imports;

use App\Models\Lead;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class LeadImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if(!empty($row['name'])) {
            return new Lead([
                'start_time' => Carbon::parse($row['start_time'])->format('Y-m-d H:i:s'),
                'name' => $row['name'],
                'phone' => $row['phone_number'],
                'city' => $row['city'],
                'state' => $row['state'],
                'source' => $row['source'],
                'lead_tag' => $row['lead_tag'],
                'qualification_status' => $this->mapQualificationStatus($row['qualifiedunqualified']),
                'rating' => $row['lead_rating'],
                'note' => $row['additional_notes_intake_team'],
                'note_strike_first' => $row['notes_strike_first'],
                'action' => $row['listen_to_recording_action_needed'],
                'status' => $row['lead_status'],
                'lead_id' => $row['lead_id']
            ]);
        }
    }

    /**
     * Map qualification status to a numerical value (e.g., 0 for Unqualified, 1 for Qualified)
     *
     * @param string $qualification
     * @return int
     */
    private function mapQualificationStatus($qualification)
    {
        if (strtolower($qualification) === 'qualified') {
            return 1;
        }
        return 0;
    }
}
