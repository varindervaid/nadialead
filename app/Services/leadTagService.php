<?php

namespace App\Services;

use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\LeadTag;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

class leadTagService
{
    public function getList($inputs)
    {
        
        try {
            // Set default values for parameters
            $perPage = $inputs["perPage"] ?? ($inputs["params"] ?? 10);
            $sortOrder = $inputs['sortOrder'] ?? 'DESC';
            $sortBy = $inputs['sortBy'] ?? 'id';

            // Initialize query
            $leadTags = LeadTag::orderBy($sortBy, $sortOrder);

            // Apply role filters
            // if (!empty($inputs['filters']['role'])) {
            //     $users->whereHas('roles', function ($query) use ($inputs) {
            //         $query->where('name', $inputs['filters']['role']);
            //     });
            // }

            // Apply user type filter
            // if (!empty($inputs['user_type'])) {
            //     $users->whereHas('roles', function ($query) use ($inputs) {
            //         $query->where('name', $inputs['user_type']);
            //     });
            // }

            // Apply search filter
            // if (!empty($inputs["search"])) {
            //     $search = trim($inputs["search"]);
            //     $users->where('email', 'LIKE', '%' . $search . '%');
            // }

            // Return paginated or all results based on perPage value
          
            return $perPage != 'all' ? $leadTags->paginate($perPage) : $leadTags->get();

        } catch (\Exception | RequestException $e) {
            Log::error('Lead Tag fetch service failed', ['error' => $e->getMessage()]);
            throw $e;
        }

    }

    public function store($inputs)
    {
        
        try {
            $model = LeadTag::create($inputs);
            return $model;
        } catch (\Exception  | RequestException $e) {
            Log::error('lrad tag store service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show($leadTag)
    {
        return $leadTag;
    }

    public function update($inputs, $id)
    {
        try {
            $leadTag = LeadTag::find($id);
            
            $leadTag->update($inputs);
            return $leadTag;
        } catch (\Exception  | RequestException $e) {
            Log::error('lead tag update service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function destroy($id){
        try {
            $leadTag = LeadTag::findOrFail($id);  // Find the record or throw a 404 exception
            
            $leadTag->delete();  // Delete the record
            
            return true;  // Return true on successful deletion
        } catch (\Exception | RequestException $e) {
            Log::error('Lead tag delete service', ['error' => $e->getMessage()]);
            throw $e;  // Rethrow the exception
        }
    }


    

    

    
    

    

    

    
}
