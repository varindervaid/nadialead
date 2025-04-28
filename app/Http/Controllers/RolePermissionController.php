<?php

namespace App\Http\Controllers;

use App\Http\Resources\RoleCollection;
use App\Services\roleService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RolePermissionController extends Controller
{
      /**
     * Create a new controller instance.
     *
     * @return void
     */
    use ApiResponse;

    protected $roleService;

    public function __construct(roleService $roleService = null)
    {
        $this->roleService = $roleService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $responseArr = [];
            $inputs = $request->all();
            $roles = new RoleCollection($this->roleService->getList($inputs));
            $responseArr = $roles->response()->getData(true);
            $responseArr['message'] = 'Roles fetched successfully.';
            return $this->successResponse($responseArr);
        } catch (\Exception $e) {
            Log::error('Roles fetched_api', ['error' => $e->getMessage()]);
            report($e);
            return $this->failResponse();
        }
    }
}
