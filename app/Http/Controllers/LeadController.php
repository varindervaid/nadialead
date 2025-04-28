<?php

namespace App\Http\Controllers;

use App\Http\Requests\LeadUpdateRequest;
use Illuminate\Http\Request;
use App\Imports\LeadImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use App\Services\LeadService;
use App\Http\Resources\LeadCollection;
use App\Http\Resources\LeadResource;
use App\Models\Lead;
use Illuminate\Support\Facades\Auth;

class LeadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    use ApiResponse;

    protected $leadService;

    public function __construct(LeadService $leadService = null)
    {
        $this->leadService = $leadService;
    }
    // Import leads from the uploaded Excel file
    public function importLead(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lead_file' => 'required|file|mimes:xlsx,csv',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors()
            ], 422);
        }
        try {
            Excel::import(new LeadImport, $request->file('lead_file'));
            return response()->json([
                'status'  => true,
                'message' => 'Leads imported successfully!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to import leads: ' . $e->getMessage()
            ], 500);
        }
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
            $leads = new LeadCollection($this->leadService->getList($inputs));
            $responseArr = $leads->response()->getData(true);
            $responseArr['message'] = 'Leads fetched successfully.';
            return $this->successResponse($responseArr);
        } catch (\Exception $e) {
            Log::error('Leads fetched api', ['error' => $e->getMessage()]);
            report($e);
            return $this->failResponse();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $responseArr = [];
            $responseArr['data'] = new LeadResource($this->leadService->show($id));
            $responseArr['message'] = 'Lead fetched Successfully.';
            return $this->successResponse($responseArr);
        } catch (\Exception $e) {
            Log::error('Lead fetched api', ['error' => $e->getMessage()]);
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
    public function update(LeadUpdateRequest $request, $id)
    {
        $responseArr = [];
        $inputs = $request->filteredData();
        try {
            $responseArr['data'] = $this->leadService->update($inputs, $id);
            $responseArr['message'] = 'Lead Updated Successfully.';
            return $this->successResponse($responseArr);
        } catch (\Exception $e) {
            Log::error('Lead update api', ['error' => $e->getMessage()]);
            report($e);
            return $this->failResponse();
        }
    }

    public function destroy($id){
        return $this->leadService->destroy($id);
    }

    public function getAllLeads(){
        return $this->leadService->getAllLeadsTags();
    }

    public function getAllLeadsTags(){
        return $this->leadService->getAllLeadsTags();
    }

    public function getAllLeadsRatings(){
        return $this->leadService->getAllLeadsRatings();    
    }

    public function getAllLeadsNoteStrikeFirst(){
        return $this->leadService->getAllLeadsNoteStrikeFirst();
    }

    public function getAllLeadsStatus(){
        return $this->leadService->getAllLeadsStatus();
    }
    
}
