<?php

namespace App\Http\Controllers;

use App\Models\LeadRating;
use Illuminate\Http\Request;
use App\Services\leadRatingService;
use App\Http\Requests\LeadRatingRequest;
use App\Http\Resources\LeadRatingCollection;
use App\Http\Resources\LeadRatingResource;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;

class LeadRatingController extends Controller
{
    use ApiResponse;

    protected $leadRatingService;

    public function __construct(leadRatingService $leadRatingService)
    {


        $this->leadRatingService = $leadRatingService;

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        try {
            $responseArr = [];
            $inputs = $request->all();
            $leadRatings = new LeadRatingCollection($this->leadRatingService->getList($inputs));

            $responseArr = $leadRatings->response()->getData(true);

            $responseArr['message'] = 'Lead Rating fetched successfully.';
            return $this->successResponse($responseArr);
        } catch (\Exception $e) {
            Log::error('Lead Rating fetched_api', ['error' => $e->getMessage()]);
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
    public function store(LeadRatingRequest $request)
        {

            $responseArr = [];
            $inputs = $request->all();

            try {
                $responseArr['data'] = $this->leadRatingService->store($inputs);
                $responseArr['message'] = 'Lead Rating Created Successfully.';
                return $this->successResponse($responseArr);
            } catch (\Exception $e) {
                Log::error('Lead Rating store api', ['error' => $e->getMessage()]);
                report($e);
                return $this->failResponse();
            }

        }
    /**
     * Display the specified resource.
     */
    public function show(LeadRating $leadRating) {

        try {

            $responseArr = [];
            $responseArr['data'] = new LeadRatingResource($this->leadRatingService->show($leadRating));

            $responseArr['message'] = 'Lead Rating fetched Successfully.';
            return $this->successResponse($responseArr);
        } catch (\Exception $e) {
            Log::error('Lead Rating fetched api', ['error' => $e->getMessage()]);
            report($e);
            return $this->failResponse();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeadRating $leadRating)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LeadRatingRequest $request , $id)
        {

            $responseArr = [];
            $inputs = $request->all();
            try {
                $responseArr['data'] = $this->leadRatingService->update($inputs,$id);
                $responseArr['message'] = 'Lead Rating Updated Successfully.';
                return $this->successResponse($responseArr);
            } catch (\Exception $e) {
                Log::error('Lead Rating update api', ['error' => $e->getMessage()]);
                report($e);
                return $this->failResponse();
            }
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        try {
            $this->leadRatingService->destroy($id);  // Call the delete service method

            $responseArr = [
                'message' => 'Lead Rating deleted successfully.'
            ];

            return $this->successResponse($responseArr, 200);
        } catch (\Exception $e) {
            Log::error('Lead Rating delete api', ['error' => $e->getMessage()]);
            report($e);

            return $this->failResponse('Failed to delete Lead Rating', 500);
        }
    }
}
