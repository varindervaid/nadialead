<?php

namespace App\Services;

use App\Helpers\ApiResponse;
use App\Models\User;
use App\Models\Status;

use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cookie;

class StatusService
{
    public function getList($inputs)
    {

        try {
            // Set default values for parameters
            $perPage = $inputs["perPage"] ?? ($inputs["params"] ?? 10);
            $sortOrder = $inputs['sortOrder'] ?? 'DESC';
            $sortBy = $inputs['sortBy'] ?? 'id';

            // Initialize query
            $status = Status::orderBy($sortBy, $sortOrder);

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

            return $perPage != 'all' ? $status->paginate($perPage) : $status->get();

        } catch (\Exception | RequestException $e) {
            Log::error('Status fetch service failed', ['error' => $e->getMessage()]);
            throw $e;
        }

    }

    public function store($inputs)
    {

        try {
            $model = Status::create($inputs);
            return $model;
        } catch (\Exception  | RequestException $e) {
            Log::error('Status store service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function show($status)
    {
        return $status;
    }

    public function update($inputs, $id)
    {
        try {
            $status = Status::find($id);

            $status->update($inputs);
            return $status;
        } catch (\Exception  | RequestException $e) {
            Log::error('Status update service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function destroy($id){
        try {
            $status = Status::findOrFail($id);  // Find the record or throw a 404 exception

            $status->delete();  // Delete the record

            return true;  // Return true on successful deletion
        } catch (\Exception | RequestException $e) {
            Log::error('Status delete service', ['error' => $e->getMessage()]);
            throw $e;  // Rethrow the exception
        }
    }














}
