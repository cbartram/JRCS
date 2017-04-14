<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Donations;
use App\Notification;
use App\Profile;
use App\Programs;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ArchiveController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

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

        $notifications = Notification::where('to', Auth::user()->id)
            ->where('active', 0)
            ->paginate(10);

        return view('donation.archive', compact('donations'), compact('volunteers'))
            ->with('programs', $programs)
            ->with('events', $events)
            ->with('defaultGroup', Session::get('group'))
            ->with('notifications', $notifications);
    }

}
