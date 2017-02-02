<?php

namespace App\Http\Controllers;

use App\Cico;
use App\Helpers\Helpers;
use App\Profile;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Kamaln7\Toastr\Facades\Toastr;

class SearchController extends Controller
{
    /**
     * Handles showing the volunteer information after a search is made on their email
     * or after a link is clicked for more volunteer information
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search() {

        $group = Helpers::getGroupNameFromTruncated(Input::get('group'));

        $id = Helpers::getId(Input::get('email'));

        //email address was invalid
        if($id == null) {
            Toastr::error("Volunteer could not be located in the group " . Input::get('group'));
            return Redirect::back();
        }

        if($group == "error") {
            //user is admin
            $volunteer = Profile::find($id);
        } else {
            $volunteer = Profile::where('id', $id)
                ->where($group, 1)->first();
        }

        //email address was valid but wrong for the group
        if($volunteer == null) {
            Toastr::error("Volunteer could not be located in the group " . Input::get('group'));
            return Redirect::back();
        }

        $cico = Cico::where('email', Input::get('email'))
            ->orderBy('check_in_timestamp', 'ASC')
            ->paginate(5);

        return view('search-results', compact('cico'), compact('volunteer'));

    }

    /**
     * Handles searching for volunteers in the database by first name or last name
     * and showing links to specific volunteers
     *
     */
    public function find() {
        $name = Input::get('email');
        $group = Helpers::getGroupNameFromTruncated(Input::get('group'));

        $name = '%' . $name . '%';

        if($group != "ADMIN") {
            //Find volunteers matching selection for the specific group
            $volunteers = Profile::where('first_name', 'LIKE', $name)
                ->where($group, 1)
                ->orWhere('last_name', 'LIKE', $name)
                ->get();
        } else {
            //we are admin and can search all 3 groups
            $volunteers = Profile::where('first_name', 'LIKE', $name)
                ->orWhere('last_name', 'LIKE', $name)
                ->get();
        }

        //No volunteers found sorry :(
        if($volunteers->isEmpty()) {
            Toastr::error('No volunteers were found matching your search criteria sorry!');
            return Redirect::back();
        }

        return view('search-name', compact('volunteers'));

    }
}
