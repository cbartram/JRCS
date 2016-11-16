<?php

namespace App\Http\Controllers;

use App\Donations;
use App\Profile;

class ArchiveController extends Controller
{
    public function index() {

        $donations = Donations::where('status', 'Approved')
            ->orWhere('status', 'Denied')
            ->orderBy('status', 'DESC')
            ->get();

        $volunteers = Profile::where('active', 0)
            ->orderBy('last_name', 'ASC')
            ->get();

        return view('donation.archive', compact('donations'), compact('volunteers'));
    }

}
