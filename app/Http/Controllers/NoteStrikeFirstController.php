<?php

namespace App\Http\Controllers;

use App\Models\NoteStrikeFirst;
use Illuminate\Http\Request;
use App\Services\UserService;
use App\Services\NoteStrikeFirstService;
use App\Http\Requests\UserPostRequest;
use App\Http\Requests\NoteStrikeFirstRequest;
use App\Http\Resources\NoteStrikeFirstCollection;
use App\Http\Resources\NoteStrikeFirstResource;
use App\Traits\ApiResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Arr;

class NoteStrikeFirstController extends Controller
{
    use ApiResponse;

    protected $noteStrikeFirstService;

    public function __construct(NoteStrikeFirstService $noteStrikeFirstService)
    {


        $this->noteStrikeFirstService = $noteStrikeFirstService;

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        try {
            $responseArr = [];
            $inputs = $request->all();
            $noteStrike = new NoteStrikeFirstCollection($this->noteStrikeFirstService->getList($inputs));

            $responseArr = $noteStrike->response()->getData(true);

            $responseArr['message'] = 'Note Strike fetched successfully.';
            return $this->successResponse($responseArr);
        } catch (\Exception $e) {
            Log::error('Note Strike fetched_api', ['error' => $e->getMessage()]);
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
    public function store(NoteStrikeFirstRequest $request){

            $responseArr = [];
            $inputs = $request->all();

            try {
                $responseArr['data'] = $this->noteStrikeFirstService->store($inputs);
                $responseArr['message'] = 'Note strike Created Successfully.';
                return $this->successResponse($responseArr);
            } catch (\Exception $e) {
                Log::error('Note strike store api', ['error' => $e->getMessage()]);
                report($e);
                return $this->failResponse();
            }

    }
    /**
     * Display the specified resource.
     */
    public function show(NoteStrikeFirst $NoteStrikeFirst) {

        try {

            $responseArr = [];
            $responseArr['data'] = new NoteStrikeFirstResource($this->noteStrikeFirstService->show($NoteStrikeFirst));

            $responseArr['message'] = 'Note strike fetched Successfully.';
            return $this->successResponse($responseArr);
        } catch (\Exception $e) {
            Log::error('Note Strike fetched api', ['error' => $e->getMessage()]);
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
    public function update(NoteStrikeFirstRequest $request , $id)
        {

            $responseArr = [];
            $inputs = $request->all();
            try {
                $responseArr['data'] = $this->noteStrikeFirstService->update($inputs,$id);
                $responseArr['message'] = 'Note strike Updated Successfully.';
                return $this->successResponse($responseArr);
            } catch (\Exception $e) {
                Log::error('Note strike update api', ['error' => $e->getMessage()]);
                report($e);
                return $this->failResponse();
            }
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id){
        try {
            $this->noteStrikeFirstService->destroy($id);  // Call the delete service method

            $responseArr = [
                'message' => 'Note strike deleted successfully.'
            ];

            return $this->successResponse($responseArr, 200);
        } catch (\Exception $e) {
            Log::error('Note strike delete api', ['error' => $e->getMessage()]);
            report($e);

            return $this->failResponse('Failed to delete Lead Rating', 500);
        }
    }
}
