<?php

namespace App\Http\Controllers\REST;

use App\Profile;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RESTController extends Controller
{
    public function all() {
        return Profile::all();
    }

    public function findById($id) {
        return Profile::find($id);
    }

    public function findByEmail($email) {
        return DB::table('profiles')->where('email', '=', $email)->limit(1)->get();
    }

    public function deleteById($id) {
        return DB::table('profiles')->where('id', '=', $id)->delete();
    }

    public function deleteByEmail($email) {
        return DB::table('profiles')->where('email', '=', $email)->delete();
    }

    public function updateById($id, $columnToUpdate, $newValue) {
        $volunteer = Profile::find($id);
        $volunteer->$columnToUpdate = $newValue;

        $volunteer->save();
    }

    public function updateByEmail($email, $columnToUpdate, $newValue) {
        $volunteer = Profile::where('email', '=', $email)->limit(1)->first();
        $volunteer->$columnToUpdate = $newValue;

        $volunteer->save();
    }

}
