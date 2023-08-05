<?php

namespace App\Http\Controllers\Api;

use App\Exports\ApplicationExport;
use App\Http\Controllers\Controller;
use App\Traits\ExportTrait;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\Application\ApplicationRequest;
use App\Models\Application;
use Validator;

class ApplicationController extends BaseController
{
    use ExportTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(ApplicationRequest $request)
    {
        try {
                if ($request->hasFile('file')) {
                    $file = $request->file('file');
                    $originalName = $file->getClientOriginalName();
                    $filePath = $file->storeAs('public/images', $originalName);
                }
            $application = Application::create([
                'position_id' => $request->position_id,
                'firstname' => $request->firstname,
                'lastname'  => $request->lastname,
                'phone'     => $request->phone,
                'email'     => $request->email,
                'address'   => $request->address,
                'resume'    => $filePath??null,
                'experience'=> $request->experience,
                'messageupdate' => $request->messageupdate
            ]);
            if($application)
            {
                return $this->sendResponse([], 'Application Submitted Successfully');
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /*Export Applications*/
    public function exportApplications()
    {
        try {
            $export = new ApplicationExport();

            return $this->sendResponse([
                'file_url' => $this->generateExport('application', 'xls', $export)
            ], 'Applications exported successfully.');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            return $this->sendError(['error' => $failures]);
        } catch (\Exception $e) {
            return $this->sendError(['error' => $e->getMessage()]);
        }
    }
}
