<?php

namespace App\Http\Controllers\Api;

use App\Classes\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Position\PositionRequest;
use App\Http\Requests\PaginateRequest;
use Illuminate\Http\Request;
use App\Models\Position;
use Illuminate\Support\Facades\DB;

class PositionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PaginateRequest $request)
    {
        try {
            $position = Position::where('status', 'active')
                ->get($request->per_page ?? 10);

            return $this->sendResponse([$position], 'All Position');
        } catch (\Throwable $th)
        {
            return $this->sendError(['error' => $th->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(PositionRequest $request)
    {
        try {
            DB::beginTransaction();
            $position = $this->storeOrUpdateDepartment($request);
            if(isset($position->id))
            {
                DB::commit();
                return $this->sendResponse([$position], 'Position created successfully.');
            }
            DB::rollback();
            return $this->sendError([], 'Something went wrong! Please try again later.');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendError($e->getMessage(), 'Something went wrong! Please try again later.');
        }
    }

    private function storeOrUpdateDepartment($request)
    {
        try {
            return Position::updateOrCreate(
                ['id' => $request->position_id],
                [
                    'department_id'  => $request->department_id ?? null,
                    'position'       => $request->position ?? null,
                    'status'         => $request->status ?? null
                ]
            );
        } catch (\Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $position = Position::whereId($id)->first();
            if ($position) {
                return $this->sendResponse([$position], 'Specific position retrieved successfully.');
            }
            return $this->sendError([], 'Position Not Found!');
        } catch (\Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $request['department_id'] = (int)$id;
            $position = $this->storeOrUpdateDepartment($request);
            DB::commit();
            return $this->sendResponse([$position->fresh()], 'Position updated successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendError('Error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $position = Position::findOrFail($id);
            $response = $position->delete();

            if ($response) {
                return $this->sendResponse([], 'Position deleted successfully.');
            }
            return $this->sendError([], 'Failed to delete the position.');
        } catch (\Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }
}
