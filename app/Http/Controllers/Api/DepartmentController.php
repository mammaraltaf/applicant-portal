<?php

namespace App\Http\Controllers\Api;

use App\Classes\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Department\DepartmentRequest;
use App\Http\Requests\PaginateRequest;
use Illuminate\Http\Request;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class DepartmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PaginateRequest $request)
    {
        try {
            $department = Department::where('status', 'active')
                ->with('positions')
                ->paginate($request->per_page ?? 10);

            return $this->sendResponse([$department], 'All Departments');
        } catch (\Throwable $th) {
            return $this->sendError(['error' => $th->getMessage()]);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DepartmentRequest $request)
    {
        try {
            DB::beginTransaction();
            $department = $this->storeOrUpdateDepartment($request);
            if(isset($department->id))
            {
                DB::commit();
                return $this->sendResponse([$department], 'Department created successfully.');
            }
            DB::rollback();
            return $this->sendError([$facility], 'Something went wrong! Please try again later.');
        } catch (\Exception $e) {
            DB::rollback();
            return $this->sendError($e->getMessage(), 'Something went wrong! Please try again later.');
        }
    }

    private function storeOrUpdateDepartment($request)
    {
        try {
            return Department::updateOrCreate(
                ['id'  => $request->department_id],
                [
                    'facility_id' => $request->facility_id ?? null,
                    'department'  => $request->department ?? null,
                    'status'      => $request->status ?? null
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
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $department = Department::whereId($id)->first();
            /*check if facility found or not*/
            if ($department) {
                return $this->sendResponse([$department], 'Specific department retrieved successfully.');
            }
            return $this->sendError([], 'Department Not Found!');
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $request['department_id'] = (int)$id;
            $department = $this->storeOrUpdateDepartment($request);
            DB::commit();
            return $this->sendResponse([$department->fresh()], 'Department updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $department = Department::findOrFail($id);
            $response = $department->delete();

            if ($response) {
                return $this->sendResponse([], 'Department deleted successfully.');
            }
            return $this->sendError([], 'Failed to delete the department.');
        } catch (\Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }
}
