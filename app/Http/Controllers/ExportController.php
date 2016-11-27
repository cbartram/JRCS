<?php

namespace App\Http\Controllers;

use App\Cico;
use App\EventLog;
use App\Helpers\Helpers;
use App\Profile;
use Carbon\Carbon;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Kamaln7\Toastr\Facades\Toastr;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{

    /**
     * Exports Data into an excel format
     */
    public function export() {
        $rules = array(
            'start' => 'required',
            'end' => 'required',
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {

            Toastr::error('Start & end dates are required for Excel Exporting', $title = "Required Fields Missing", $options = []);
            return Redirect::to('/profile')
                ->withErrors($validator)
                ->withInput();
        }

        if(Carbon::createFromFormat('Y-m-d', Input::get('start')) == false || Carbon::createFromFormat('Y-m-d', Input::get('end')) == false) {
            Toastr::error('Start & end dates must be in the format YYYY-MM-DD', $title = "Invalid Date Format", $options = []);
            return Redirect::to('/profile');
        }

        Excel::create(Input::get('group') . ' Volunteer Data', function($excel) {
            $excel->sheet('Volunteers', function($sheet) {

                // first row styling and writing content
                $sheet->mergeCells('A1:E1');

                $sheet->cell('A1', function ($cell) {
                    $cell->setAlignment('center');
                    $cell->setFontFamily('Helvetica Neue');
                    $cell->setFontSize(16);
                });

                $sheet->row(1, array(Input::get('group') . ' Volunteer Data'));

                //get the events for the group where its been logged already
                $events = EventLog::select('event_log.total_volunteer_hours', 'calendar_events.title')
                    ->join('calendar_events', 'calendar_events.id', '=', 'event_log.event_id')
                    ->where('event_log.group', Input::get('group'))
                    ->where('event_log.log_status', 1)->get()->toArray();


                // setting column names for data - you can of course set it manually
                $sheet->appendRow(array_keys($events[0])); // column names

                // putting data as next rows
                foreach ($events as $event) {
                    $sheet->appendRow($event);
                }

                $result = Cico::where(Helpers::getGroupNameFromTruncated(Input::get('group')), 1)
                    ->where('check_in_date', '>=', Input::get('start'))
                    ->where('check_out_date', '<=', Input::get('end'))
                    ->sum('minutes_volunteered');

                $result = Helpers::minutesToHours($result);

                //Set the font weight for the headers
                $sheet->cell('A2:E2', function($cell) {
                    $cell->setFontWeight('bold');
                });

                //Manually Set next row header for additional data
                $sheet->cell('E2', 'Total Hours for ' . Input::get('group'));
                $sheet->cell('E3', $result);

                //Set headers for individual hours volunteered on specific dates
                $sheet->cell('C2', 'Date');
                $sheet->cell('D2', 'Hours Volunteered');

                //for each day between start and end dates show hours volunteered for group on that day
                $dates = $this->generateDateRange(Carbon::createFromFormat('Y-m-d', Input::get('start')), Carbon::createFromFormat('Y-m-d', Input::get('end')));

                $results = [];
                for($i = 0; $i < sizeof($dates); $i++) {
                    $result = Cico::where(Helpers::getGroupNameFromTruncated(Input::get('group')), 1)
                        ->where('check_in_date', '=', $dates[$i])
                        ->where('check_out_date', '=', $dates[$i])
                        ->sum('minutes_volunteered');


                    array_push($results, Helpers::minutesToHours(intval($result)));
                }

                //map the array values of dates to be the array keys in results
                $arr = array_combine($dates, $results);

                $arrKeys = array_keys($arr);
                $arrValues = array_values($arr);

                //we start at cell E/F 3 because of the titles
                $counter = 3;

                for($i = 0; $i < sizeof($arr); $i++) {

                    $eIndex = 'C' . strval($counter);
                    $fIndex = 'D' . strval($counter);

                    //E index
                    $sheet->cell($eIndex, $arrKeys[$i]);

                    //F index
                    $sheet->cell($fIndex, $arrValues[$i]);

                    $counter++;
                }

            });
        })->export('xls');

        Toastr::success('Successfully exported data to excel format!', $title = "Export Successful", $options = []);
        return Redirect::back();
    }

    private function generateDateRange(Carbon $start_date, Carbon $end_date)
    {
        $dates = [];

        for($date = $start_date; $date->lte($end_date); $date->addDay()) {
            $dates[] = $date->format('Y-m-d');
        }

        return $dates;
    }


}
