<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Donations;
use App\Profile;
use App\Programs;

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

        $programs = Programs::where('status', 0)
            ->orderBy('program_name', 'ASC')
            ->get();

        $events = Calendar::where('active', 0)
            ->orderBy('start', 'ASC')
            ->get();

        return view('donation.archive', compact('donations'), compact('volunteers'))
            ->with('programs', $programs)
            ->with('events', $events);
    }

}
