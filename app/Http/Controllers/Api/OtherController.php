<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OtherController extends Controller
{
    public function exportFile(Request $request){
        $path = public_path('storage/'.$request->file_name);
//        return response()->download($path)->deleteFileAfterSend(true);
        return response()->download($path, $request->file_name, [
            'Content-Type' => 'application/vnd.ms-excel',
            'Content-Disposition' => "attachment; filename='.$request->file_name.'"
        ])->deleteFileAfterSend(true);
    }
}
