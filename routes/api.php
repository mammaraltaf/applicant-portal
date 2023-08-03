<?php

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\FacilityController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\PositionController;
use App\Http\Controllers\Api\ApplicationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

/*Auth Routes*/
Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:api');

/*Application Form Routes*/
Route::post('application/add',    [ApplicationController::class, 'store']);

/*Admin Routes*/
Route::middleware(['auth:api', 'verified'])->group(function () {

/*Routes for Facility*/
    Route::post('facility/add',    [FacilityController::class, 'store']);
    Route::get('facilities',       [FacilityController::class, 'index']);
    Route::post('facility/update', [FacilityController::class, 'update']);
    Route::post('facility/delete', [FacilityController::class, 'destroy']);

/*Routes for Department*/
    Route::post('department/add',    [DepartmentController::class, 'store']);
    Route::get('department',         [DepartmentController::class, 'index']);
    Route::post('department/update', [DepartmentController::class, 'update']);
    Route::post('department/delete', [DepartmentController::class, 'destroy']);
    
/*Routes for Position*/
    Route::post('position/add',    [PositionController::class, 'store']);
    Route::get('position',         [PositionController::class, 'index']);
    Route::post('position/update', [PositionController::class, 'update']);
    Route::post('position/delete', [PositionController::class, 'destroy']);
});
