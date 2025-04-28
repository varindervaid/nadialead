<?php

namespace App\Exports;

use App\Models\Lead;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LeadsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        $user = Auth::user();
        $userRole = $user->roles->first()?->name;
        $leadsQuery = Lead::query();
        if ($userRole === 'client') {
            $leadsQuery->whereHas('assigned_lead', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            });
        }
        return $leadsQuery->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Phone',
            'City',
            'State',
            'Source',
            'Lead Tag',
            'Qualification Status',
            'Rating',
            'Note',
            'Note Strike First',
            'Action',
            'Status',
            'Start Time',
            'Lead ID',
            'Assigned To',
            'Client Name',
        ];
    }

    public function map($lead): array
    {
        return [
            $lead->id,
            $lead->name,
            $lead->phone,
            $lead->city,
            $lead->state,
            $lead->source,
            $lead->lead_tag,
            $lead->qualification_status,
            $lead->rating,
            $lead->note,
            $lead->note_strike_first,
            $lead->action,
            $lead->status,
            $lead->start_time,
            $lead->lead_id,
            $lead->lead_assigned ? $lead->lead_assigned : 'Not Assigned',
            $lead->assigned_lead ? ($lead->assigned_lead->user ? $lead->assigned_lead->user->name : '') : 'N/A',
        ];
    }

}
