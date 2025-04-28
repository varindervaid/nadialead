<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadColorPostRequest;
use App\Http\Resources\LeadColorCollection;
use App\Http\Resources\LeadColorResource;
use App\Models\Lead;
use App\Models\LeadColor;
use App\Services\leadColorService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Role;

class LeadColorController extends Controller
{

    use ApiResponse;

    protected $leadColorService;

    public function __construct(leadColorService $leadColorService = null)
    {
        $this->leadColorService = $leadColorService;
    }


    /**
     * Display a listing of the resource.
     */
    public function color_list_page(Request $request, int $id = 0)
    {
        $columns = Schema::getColumnListing((new Lead())->getTable());
        $roles = Role::where('name', '!=', 'admin')->select('id', 'name')->get();
        return Inertia::render('Lead/LeadColor', compact('columns', 'roles'));
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
            $lead_colors = new LeadColorCollection($this->leadColorService->getList($inputs));
            $responseArr = $lead_colors->response()->getData(true);
            $responseArr['message'] = 'Lead Colors fetched successfully.';
            return $this->successResponse($responseArr);
        } catch (\Exception $e) {
            Log::error('Lead Colors fetched_api', ['error' => $e->getMessage()]);
            report($e);
            return $this->failResponse();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Resquest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $responseArr = [];
        $inputs = $request->all();
        try {
            $responseArr['data'] = $this->leadColorService->store($inputs);
            $responseArr['message'] = 'Lead Color Created Successfully.';
            return $this->successResponse($responseArr);
        } catch (\Exception $e) {
            Log::error('Lead Color store api', ['error' => $e->getMessage()]);
            report($e);
            return $this->failResponse();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Resquest $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $responseArr = [];
        $inputs = $request->all();
        try {
            $responseArr['data'] = $this->leadColorService->update($inputs, $id);
            $responseArr['message'] = 'Lead Color Updated Successfully.';
            return $this->successResponse($responseArr);
        } catch (\Exception $e) {
            Log::error('Lead Color update api', ['error' => $e->getMessage()]);
            report($e);
            return $this->failResponse();
        }
    }
}
