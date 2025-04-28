<?php

namespace App\Services;

use App\Helpers\ApiResponse;
use App\Models\Lead;
use App\Models\LeadAssigned;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\LeadTag;
use App\Models\LeadRating;
use App\Models\NoteStrikeFirst;
use App\Models\Status;

class leadService
{
    public function getList($inputs)
    {
        try {
            // Set default value for perPage
            $perPage = $inputs["perPage"] ?? $inputs["params"] ?? 10;
            $sortOrder = $inputs['sortOrder'] ?? 'DESC';
            $sortBy = $inputs['sortBy'] ?? 'id';
            // Initialize the Lead query
            $leads = Lead::orderBy($sortBy, $sortOrder);;
            // Apply filters if they exist
            if (!empty($inputs['filters']['leadTag'])) {
                $leads->where('lead_tag', $inputs['filters']['leadTag']);
            }
            if (!empty($inputs['filters']['rating'])) {
                $leads->where('rating', $inputs['filters']['rating']);
            }
            if (!empty($inputs['filters']['noteStrikeFirst'])) {
                $leads->where('note_strike_first', $inputs['filters']['noteStrikeFirst']);
            }
            if (!empty($inputs['filters']['status'])) {
                $leads->where('status', $inputs['filters']['status']);
            }
            // If the user is a client, apply the assigned lead filter
            if (Auth::user()->roles->first()?->name === 'client') {
                $leads->whereHas('assigned_lead', function ($query) {
                    $query->where('user_id', Auth::id());
                });
            }
            // Apply search filter
            if (!empty($inputs["search"])) {
                $search = trim($inputs["search"]);
                $leads->where(function ($q) use ($search) {
                    $q->where('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('phone', $search);
                });
            }
            // Return paginated results or all results
            return $perPage !== 'all' ? $leads->paginate($perPage) : $leads->get();
        } catch (\Exception | RequestException $e) {
            Log::error('Leads fetch service', ['error' => $e->getMessage()]);
            throw $e;
        }

    }

    public function store($inputs)
    {
        try {
            return Lead::create($inputs);
        } catch (\Exception  | RequestException $e) {
            DB::rollback();
            Log::error('lead store service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show($id)
    {
        try {
            return Lead::find($id);
        } catch (\Exception  | RequestException $e) {
            Log::error('lead fetched service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function update($inputs, $id)
    {
        try {
            $lead = lead::find($id);
            if (!empty($inputs['client_id']) && Auth::user()->roles->first()?->name == 'admin' ) {
                LeadAssigned::updateOrCreate(
                    ['lead_id' => $lead->id],
                    ['user_id' => $inputs['client_id']]
                );
            }
            $lead->fill($inputs);
            if ($lead->isDirty()) {
                return $lead->save();
            }
            return true;
        } catch (\Exception  | RequestException $e) {
            Log::error('lead update service', [
                'error' => $e->getMessage(),
                'lead_id' => $lead->id,
                'inputs' => $inputs,
            ]);
            throw $e;
        }

    }

    public function destroy($leadId){
        try {
            $lead = lead::find($leadId);
            if($lead){
                $lead->delete();
                return  ApiResponse::success('Lead Deleted successfully');
            }
        } catch (\Exception  | RequestException $e) {
            return ApiResponse::error($e->getMessage());
        }
    }

    public function getAllLeadsTags(){
        return  ApiResponse::success(LeadTag::all());
    }

    public function getAllLeadsRatings(){
        return  ApiResponse::success(LeadRating::all());
    }

    public function getAllLeadsNoteStrikeFirst(){
        return  ApiResponse::success(NoteStrikeFirst::all());
    }

    public function getAllLeadsStatus(){
        return  ApiResponse::success(Status::all());
    }
}