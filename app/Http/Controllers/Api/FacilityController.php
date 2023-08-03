<?php

namespace App\Http\Controllers\Api;

use App\Classes\StatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Facility\FacilityRequest;
use App\Http\Requests\PaginateRequest;
use App\Models\Facility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FacilityController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PaginateRequest $request)
    {
        try {
            $facility = Facility::where('status', 'active')
                ->with('departments')
                ->paginate($request->per_page ?? 10);

            return $this->sendResponse([$facility], 'All Facilities');
        } catch (\Throwable $th) {
            return $this->sendError(['error' => $th->getMessage()]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(FacilityRequest $request)
    {
        try {
            DB::beginTransaction();
            $facility = $this->storeOrUpdateFacility($request);

            if (isset($facility->id)) {
                DB::commit();
                return $this->sendResponse([$facility], 'Facility created successfully.');
            }
            DB::rollBack();
            return $this->sendError([$facility], 'Something went wrong! Please try again later.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError($e->getMessage(), 'Something went wrong! Please try again later.');
        }
    }

    private function storeOrUpdateFacility($request)
    {
        try {
            return Facility::updateOrCreate(
                ['id' => $request->facility_id],
                [
                    'name' => $request->name ?? null,
                    'address' => $request->address ?? null,
                    'city_id' => $request->city_id ?? null,
                    'state_id' => $request->state_id ?? null,
                    'zipcode' => $request->zipcode ?? null,
                    'country_id' => $request->country_id ?? null,
                    'status' => $request->status ?? null
                ]
            );
        } catch (\Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $facility = Facility::whereId($id)->first();
            /*check if facility found or not*/
            if ($facility) {
                return $this->sendResponse([$facility], 'Specific facility retrieved successfully.');
            }
            return $this->sendError([], 'Facility Not Found!');
        } catch (\Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $request['facility_id'] = (int)$id;
            $facility = $this->storeOrUpdateFacility($request);
            DB::commit();
            return $this->sendResponse([$facility->fresh()], 'Facility updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->sendError('Error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $facility = Facility::findOrFail($id);
            $response = $facility->delete();

            if ($response) {
                return $this->sendResponse([], 'Facility deleted successfully.');
            }
            return $this->sendError([], 'Failed to delete the facility.');
        } catch (\Exception $e) {
            return $this->sendError('Error', $e->getMessage());
        }
    }
}
