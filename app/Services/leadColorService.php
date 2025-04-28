<?php

namespace App\Services;

use App\Models\LeadColor;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\DB;


class leadColorService
{
    public function getList($inputs)
    {
        try {
            $perPage = !empty($inputs["params"]) ? $inputs["params"] : 10;
            $lead_colors = LeadColor::orderBy('id', 'DESC');
            if (!empty($inputs['filters'])) {
                if (!empty($inputs['filters']['role'])) {
                    $role_id = $inputs['filters']['role'];
                    $lead_colors->where('role_id', $role_id);
                }
            }
            if (isset($inputs["search"])) {
                $search = trim($inputs["search"]);
                $lead_colors = $lead_colors->where(function ($q) use ($search) {
                    $q->where('column_key', 'LIKE', '%' . $search . '%');
                });
            }
            $perPage = !empty($inputs["perPage"]) ? $inputs["perPage"] : $perPage;
            return $perPage != 'all' ? $lead_colors->paginate($perPage) : $lead_colors->get();
        } catch (\Exception | RequestException $e) {
            Log::error('lead colors fetched service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function store($inputs)
    {
        try {
            if (count($inputs['roles']) > 0) {
                foreach ($inputs['roles'] as $role_id) {
                    $inputs['role_id'] = $role_id;
                    $role = LeadColor::create($inputs);
                }
            }
            return $role;
        } catch (\Exception | RequestException $e) {
            DB::rollback();
            Log::error('lead color store service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }

    public function update($inputs, $id)
    {
        try {
            $lead_color = LeadColor::find($id);
            return $lead_color->update($inputs);
        } catch (\Exception | RequestException $e) {
            DB::rollback();
            Log::error('lead color update service', ['error' => $e->getMessage()]);
            throw $e;
        }
    }
}
