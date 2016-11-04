<?php

namespace App\Http\Controllers;

use App\Programs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Kamaln7\Toastr\Facades\Toastr;

class ProgramController extends Controller
{
    /**
     * Adds a new program to the programs table
     * for volunteers to be checked in under
     */
    public function add() {
        $rules = array(
            'program-name' => 'required',
        );

        //run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        //if the validator fails, redirect back to the form
        if ($validator->fails()) {

            Toastr::error('There were some error with your input. Ensure all the fields are filled out', $title = 'Error creating program', $options = []);
            return Redirect::to('/profile')
                ->withInput();
        }

        $program = new Programs();

        //Create new row in the database and mark it as active
        $program->id = 'prog_' . str_random(10);
        $program->program_name = Input::get('program-name');
        $program->staff_id = Input::get('id');
        $program->status = 1;

        $program->save();

        Toastr::success('Successfully added new program!', $title = "New Program Added");
        return Redirect::back();

    }

    /**
     * Handles an admin deleting a program
     */
    public function delete() {
        //find the program with the given id
        Programs::destroy(Input::get('program'));

        Toastr::success('Successfully deleted program!', $title = 'Deletion Successfully');
        return Redirect::back();
    }
}
