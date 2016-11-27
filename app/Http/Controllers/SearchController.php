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
            ->simplePaginate(5);

        return view('search-results', compact('cico'))
            ->with('volunteer', $volunteer);

    }
}
