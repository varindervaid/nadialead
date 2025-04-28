<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\leadAssignService;

class AssignLeadFieldController extends Controller
{
    public $leadAssignService;
    public function __construct()
    {
        $this->leadAssignService = new leadAssignService;
    }
    public function assignFields(Request $request){
        return $this->leadAssignService->assignFields($request);
    }

    public function getFields($id){
        return $this->leadAssignService->getFields($id);
    }

    public function getAssignFields($id){
        return $this->leadAssignService->getAssignFields($id);
    }

    public function updateFields(){

    }
}
