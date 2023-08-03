<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Department\DepartmentRequest;
use App\Http\Requests\Department\UpdaeDepartmentRequest;
use Illuminate\Http\Request;
use App\Models\Department;
use Validator;

class DepartmentController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $department = Department::where('status', 0)
                      ->with('Position')
                      ->get();
            return $this->sendResponse([$department], 'All Department');
            } catch (\Throwable $th) 
            {
            return $this->sendError(['error' => $e->getMessage()]);
            }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            $department = Department::create($request->all());
            if($department)
            {
                return $this->sendResponse([], 'Department Added Successfully');
            }

            } catch (\Exception $e) 
            {
            return $this->sendError(['error' => $e->getMessage()]);
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
        //
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
     * @return \Illuminate\Http\Response
     */
    public function update(UpdaeDepartmentRequest $request)
    {
        try {
            $department = Department::find($request->departmentId);
            if ($department) {
                $department->update([
                    'department' => $request->department ?? $department->department,
                ]);
                return $this->sendResponse([], 'Department Updated Successfully');
            }else
            {
                return $this->sendResponse([], 'No Such Department Exist');
            }
            
        } catch (\Exception $e) {
            return $this->sendError(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UpdaeDepartmentRequest $request)
    {
        
        try {
            $department = Department::find($request->departmentId);
            if ($department) {
                $department->update([
                    'status' => 1,
                    
                ]);
                return $this->sendResponse([], 'Department Deleted Successfully');
            }else
            {
                return $this->sendResponse([], 'No Such Department Exist');
            }
            
        } catch (\Exception $e) {
            return $this->sendError(['error' => $e->getMessage()]);
        }
            
       
    }
}
