<?php

namespace App\Http\Controllers;

use App\Models\Status;
use Illuminate\Http\Request;
use App\Services\StatusService;
use App\Http\Requests\StatusRequest;
use App\Http\Requests\NoteStrikeFirstRequest;
use App\Http\Resources\StatusCollection;
use App\Http\Resources\StatusResource;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class StatusController extends Controller
{
use ApiResponse;

    protected $statusService;

    public function __construct(StatusService $statusService)
    {


        $this->statusService = $statusService;

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $responseArr = [];
            $inputs = $request->all();
            $status = new StatusCollection($this->statusService->getList($inputs));

            $responseArr = $status->response()->getData(true);

            $responseArr['message'] = 'Status fetched successfully.';
            return $this->successResponse($responseArr);
        } catch (\Exception $e) {
            Log::error('Status fetched_api', ['error' => $e->getMessage()]);
            report($e);
            return $this->failResponse();
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StatusRequest $request){

            $responseArr = [];
            $inputs = $request->all();

            try {
                $responseArr['data'] = $this->statusService->store($inputs);
                $responseArr['message'] = 'Status Created Successfully.';
                return $this->successResponse($responseArr);
            } catch (\Exception $e) {
                Log::error('Status store api', ['error' => $e->getMessage()]);
                report($e);
                return $this->failResponse();
            }

    }

    /**
     * Display the specified resource.
     */
    public function show(Status $Status) {

        try {

            $responseArr = [];
            $responseArr['data'] = new StatusResource($this->statusService->show($Status));

            $responseArr['message'] = 'Status fetched Successfully.';
            return $this->successResponse($responseArr);
        } catch (\Exception $e) {
            Log::error('Status fetched api', ['error' => $e->getMessage()]);
            report($e);
            return $this->failResponse();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Status $status)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(NoteStrikeFirstRequest $request , $id)
        {

            $responseArr = [];
            $inputs = $request->all();
            try {
                $responseArr['data'] = $this->statusService->update($inputs,$id);
                $responseArr['message'] = 'Status Updated Successfully.';
                return $this->successResponse($responseArr);
            } catch (\Exception $e) {
                Log::error('Status update api', ['error' => $e->getMessage()]);
                report($e);
                return $this->failResponse();
            }
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        try {
            $this->statusService->destroy($id);  // Call the delete service method

            $responseArr = [
                'message' => 'Status deleted successfully.'
            ];

            return $this->successResponse($responseArr, 200);
        } catch (\Exception $e) {
            Log::error('Status delete api', ['error' => $e->getMessage()]);
            report($e);

            return $this->failResponse('Failed to delete Lead Rating', 500);
        }
    }
}
