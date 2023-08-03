<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Position\PositionRequest;
use App\Http\Requests\Position\UpdatePositionRequest;
use Illuminate\Http\Request;
use App\Models\Position;
use Validator;

class PositionController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $position = Position::where('status', 0)
                      ->get();
            return $this->sendResponse([$position], 'All Position');
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
    public function store(PositionRequest $request)
    {
        try {
            // return $request;
            $position = Position::create($request->all());
            if($position)
            {
                return $this->sendResponse([], 'Position Added Successfully');
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
    public function update(UpdatePositionRequest $request)
    {
        try {
            $position = Position::find($request->positionId);
            if ($position) {
                $position->update([
                    'position' => $request->position ?? $position->position,
                ]);
                return $this->sendResponse([], 'Position Updated Successfully');
            }else
            {
                return $this->sendResponse([], 'No Such Position Exist');
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
    public function destroy(UpdatePositionRequest $request)
    {
        try {
            $position = Position::find($request->positionId);
            if ($position) {
                $position->update([
                    'status' => 1,
                    
                ]);
                return $this->sendResponse([], 'Position Deleted Successfully');
            }else
            {
                return $this->sendResponse([], 'No Such Position Exist');
            }
            
        } catch (\Exception $e) {
            return $this->sendError(['error' => $e->getMessage()]);
        }
    }
}