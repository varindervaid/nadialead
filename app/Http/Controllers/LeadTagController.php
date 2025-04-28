<?php

namespace App\Http\Controllers;

use App\Models\LeadTag;
use Illuminate\Http\Request;
use App\Services\leadTagService;
use App\Http\Requests\LeadTagRequest;
use App\Http\Resources\LeadTagCollection;
use App\Http\Resources\LeadTagResource;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;








class LeadTagController extends Controller
{
    use ApiResponse;

    protected $leadTagService;

    public function __construct(leadTagService $leadTagService = null)
    {


        $this->leadTagService = $leadTagService;
    }

        /**
         * Display a listing of the resource.
         *
         * @return \Illuminate\Http\Response
        */
        public function index(Request $request){
            try {
                $responseArr = [];
                $inputs = $request->all();
                $leadTags = new LeadTagCollection($this->leadTagService->getList($inputs));

                $responseArr = $leadTags->response()->getData(true);

                $responseArr['message'] = 'Lead Tags fetched successfully.';
                return $this->successResponse($responseArr);
            } catch (\Exception $e) {
                Log::error('Lead Tags fetched_api', ['error' => $e->getMessage()]);
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
        public function store(LeadTagRequest $request)
        {

            $responseArr = [];
            $inputs = $request->all();

            try {
                $responseArr['data'] = $this->leadTagService->store($inputs);
                $responseArr['message'] = 'Lead Tag Created Successfully.';
                return $this->successResponse($responseArr);
            } catch (\Exception $e) {
                Log::error('Lead Tag store api', ['error' => $e->getMessage()]);
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
        public function show(LeadTag $leadTag) {
            try {
                $responseArr = [];
                $responseArr['data'] = new LeadTagResource($this->leadTagService->show($leadTag));
                $responseArr['message'] = 'Lead Tag fetched Successfully.';
                return $this->successResponse($responseArr);
            } catch (\Exception $e) {
                Log::error('Lead Tag fetched api', ['error' => $e->getMessage()]);
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
        public function update(LeadTagRequest $request , $id)
        {

            $responseArr = [];
            $inputs = $request->all();
            try {
                $responseArr['data'] = $this->leadTagService->update($inputs,$id);
                $responseArr['message'] = 'Lead Tag Updated Successfully.';
                return $this->successResponse($responseArr);
            } catch (\Exception $e) {
                Log::error('Lead Tag update api', ['error' => $e->getMessage()]);
                report($e);
                return $this->failResponse();
            }
        }

    public function destroy($id){
        try {
            $this->leadTagService->destroy($id);  // Call the delete service method

            $responseArr = [
                'message' => 'Lead Tag deleted successfully.'
            ];

            return $this->successResponse($responseArr, 200);
        } catch (\Exception $e) {
            Log::error('Lead Tag delete api', ['error' => $e->getMessage()]);
            report($e);

            return $this->failResponse('Failed to delete Lead Tag', 500);
        }
    }

}
