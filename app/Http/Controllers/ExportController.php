<?php

namespace App\Http\Controllers;

use App\Profile;
use Illuminate\Support\Facades\Redirect;
use Kamaln7\Toastr\Facades\Toastr;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    /**
     * Exports Data into an excel format
     */
    public function export() {
        $volunteers = Profile::select('first_name', 'last_name', 'id', 'email')->get();

        Excel::create('Volunteers', function($excel) use($volunteers) {
            $excel->sheet('Sheet 1', function($sheet) use($volunteers) {
                $sheet->fromArray($volunteers);
            });
        })->export('xls');

        Toastr::success('Successfully exported data to excel format!', $title = "Export Successful", $options = []);
        return Redirect::back();
    }
}
