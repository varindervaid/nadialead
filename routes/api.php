<?php

use App\Http\Controllers\LeadColorController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\LeadTagController;
use App\Http\Controllers\LeadRatingController;
use App\Http\Controllers\NoteStrikeFirstController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\RolePermissionController;
use App\Exports\LeadsExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\AssignLeadFieldController;
use App\Http\Controllers\StatusController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->prefix('v1')->group(function () {
    Route::post('login', 'login');
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    Route::get('leads/export', function () {
        return Excel::download(new LeadsExport, 'leads.xlsx');
    });

    // Admin-specific routes
    Route::middleware('isAdmin')->group(function () {
        Route::apiResource('users', UserController::class);
        Route::apiResource('leadcolors', LeadColorController::class);
        Route::apiResource('roles', RolePermissionController::class)->only('index');
        Route::apiResource('lead/tags', LeadTagController::class);
        Route::apiResource('lead/ratings', LeadRatingController::class);
        Route::apiResource('note/strike/first', NoteStrikeFirstController::class);
        Route::apiResource('status', StatusController::class);
        Route::get('dashboard/data', [UserController::class, 'dashboardData']);
        Route::get('get/all/leads/tags', [LeadController::class, 'getAllLeadsTags']);
        Route::get('get/all/leads/ratings', [LeadController::class, 'getAllLeadsRatings']);
        Route::get('get/all/leads/note/strike/first', [LeadController::class, 'getAllLeadsNoteStrikeFirst']);
        Route::get('get/all/leads/status', [LeadController::class, 'getAllLeadsStatus']);
    });

    // Apply the custom CheckLeadAssigned middleware to the update route
    Route::apiResource('leads', LeadController::class)->only(['index', 'destroy']);
    Route::put('leads/{id}', [LeadController::class, 'update'])->middleware('CheckLeadAssigned');
    Route::get('leads/{id}', [LeadController::class, 'show'])->name('leads.edit')->middleware('CheckLeadAssigned');

    // Other routes
    Route::post('import/lead', [LeadController::class, 'importLead']);
    Route::get('user/profile', [AuthController::class, 'userProfile']);
    Route::post('update/profile', [AuthController::class, 'updateProfile']);
    Route::post('update/profile/password', [AuthController::class, 'updateProfilePassword']);


    Route::controller(AssignLeadFieldController::class)->group(function () {
        Route::get('get/fields/{id}', 'getFields');
        Route::get('get/assign/fields/{id}', 'getAssignFields');
        Route::post('assign/fields', 'assignFields');
    });
});

// Route::apiResource('users', UserController::class);


Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
// Route::get('get-user', function(){
//     return Auth::guard('api')->user();
// });
