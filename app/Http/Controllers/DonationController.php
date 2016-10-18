<?php

namespace App\Http\Controllers;

use App\Donations;
use App\Helpers\Helpers;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DonationController extends Controller
{
    public function handleDonation()
    {
        $rules = array(
            'email' => 'required|email',
            'type' => 'max:100',
            'inkind' => 'max:100'
        );

        $validator = Validator::make(Input::all(), $rules);

        if ($validator->fails()) {

            return Redirect::to('/donation')
                ->withErrors($validator)
                ->withInput();

        }

        $id = Helpers::getId(Input::get('email'));
        if($id == null) {
            return Redirect::back()
                ->withErrors('Invalid Email Address');
        }
        $date = date('Y-m-d');
        $time = date('G:i:s');

        //subtract 4 hours from UTC time to get the current time in florida knowing 3600 seconds in one hour
        $timestamp = $date . ' ' . date("g:i a", strtotime($time) - (4 * 3600));

        $donation = new Donations();
        $donation->volunteer_id = $id;
        $donation->group_name = Input::get('group');
        $donation->donation_type = Input::get('donation-type');

        switch(Input::get('donation-type')) {
            case 'Monetary':
                $donation->donation_value = Input::get('amount');
                $donation->donation_description = 'Monetary Donation';
                break;
            case 'Supplies':
                $donation->donation_value = 0;
                $donation->donation_description = Input::get('type');
                break;
            case 'In Kind':
                $donation->donation_value = 0;
                $donation->donation_description = Input::get('inkind');
                break;
        }

        $donation->status = 'pending';
        $donation->date = $timestamp;
        $donation->save();

        return Redirect::back()
            ->with('status', 'Successfully Submitted Donation Information');
    }
}
