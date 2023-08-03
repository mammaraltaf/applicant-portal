<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Facility\FacilityRequest;
use App\Http\Requests\Facility\UpdateFacilityRequest;
use Illuminate\Http\Request;
use App\Models\Facility;
use Validator;

class FacilityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $facility = Facility::where('status', 0)
                      ->with('Department')
                      ->get();
            return $this->sendResponse([$facility], 'All Facilities');
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
    public function store(FacilityRequest $request)
    {
        try {
            $facility = Facility::create($request->all());
            if($facility)
            {
                return $this->sendResponse([], 'Facility Added Successfully');
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
    public function update(UpdateFacilityRequest $request)
    {
        try {
            $facility = Facility::find($request->facilityId);
            if ($facility) {
                $facility->update([
                    'facility' => $request->facility ?? $facility->facility,
                    'address'  => $request->address ?? $facility->address,
                    'city'     => $request->city ?? $facility->city,
                    'state'    => $request->state ?? $facility->state,
                    'zip'      => $request->zip ?? $facility->zip
                ]);
                return $this->sendResponse([], 'Facility Updated Successfully');
            }else
            {
                return $this->sendResponse([], 'No Such Facility Exist');
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
    public function destroy(UpdateFacilityRequest $request)
    {
        try {
            $facility = Facility::find($request->facilityId);
            if ($facility) {
                $facility->update([
                    'status' => 1,
                    
                ]);
                return $this->sendResponse([], 'Facility Deleted Successfully');
            }else
            {
                return $this->sendResponse([], 'No Such Facility Exist');
            }
            
        } catch (\Exception $e) {
            return $this->sendError(['error' => $e->getMessage()]);
        }
    }
}