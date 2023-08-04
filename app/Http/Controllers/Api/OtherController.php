<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Application;
use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use App\Models\Facility;
use App\Models\Position;
use App\Models\State;
use Illuminate\Http\Request;

class OtherController extends BaseController
{

    public function dashboard()
    {
        $facilities = Facility::count();
        $departments = Department::count();
        $positions = Position::count();
        $applications = Application::count();

        $data = [
            'facilities' => $facilities,
            'departments' => $departments,
            'positions' => $positions,
            'applications' => $applications,
        ];

        return $this->sendResponse([$data], 'Dashboard');

    }

    public function exportFile(Request $request){
        $path = public_path('storage/'.$request->file_name);
//        return response()->download($path)->deleteFileAfterSend(true);
        return response()->download($path, $request->file_name, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename='.$request->file_name.'"
        ])->deleteFileAfterSend(true);
    }

    public function getCountries()
    {
        $countries = Country::select('id','name')->get();
        return $this->sendResponse($countries, 'All Countries');
    }

    public function getStates($id)
    {
        $states = State::where('country_id', $id)->select('id','name')->get();
        return $this->sendResponse($states, 'All States');
    }


    public function getCities($id)
    {
        $cities = City::where('state_id', $id)->select('id','name')->get();
        return $this->sendResponse($cities, 'All Cities');
    }

}
