<?php

namespace App\Http\Controllers;

use App\Helpers\Helpers;
use App\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Kamaln7\Toastr\Facades\Toastr;
use Mockery\Matcher\Not;
use Vinkla\Pusher\PusherManager;

class NotificationController extends Controller
{
    /**
     * Recieves the JS Post request and forwards the data onto
     * the pusher cloud
     *
     * @param Request $request POST Request
     * @param PusherManager $pusher Pusher object
     */
    public function notify(Request $request, PusherManager $pusher) {

        $notifyText = e($request->input('notify_text'));
        $to = $request->input('to');
        $from = $request->input('from');
        $fromName = $request->input('from-name');
        $fromEmail = $request->input('from-email');

        $notification = new Notification();

        $notification->unread = 1;
        $notification->to = $to;
        $notification->from = $from;
        $notification->message = $notifyText;
        $notification->name = $fromName;
        $notification->active = 1;

        $notification->save();

        $pusher->trigger('test-channel', 'test-event', ['text' => $notifyText, 'to' => $to, 'from' => $from, 'name' => $fromName, 'email' => $fromEmail]);

        Toastr::success('Message to ' . Helpers::getStaffName($to) . ' Sent Successfully!');
        return Redirect::back();

    }


    /**
     * Archives all Notifications for a user
     * @param $id
     */
    public function clearAll($id) {
         Notification::where('active', 1)
            ->where('to', $id)
            ->update(['active' => 0]);

       Toastr::success('Your notifications have been cleared!');
       return Redirect::back();

    }


    /**
     * Updates a notifications status to read from unread
     *
     * @param $id
     * @return mixed
     */
    public function read($id) {
        $notif = Notification::find($id);

        $notif->unread = 0;
        $notif->save();

        return Redirect::back();
    }



    /**
     * Removes a notifiation by making in inactive
     * @param $id
     */
    public function remove($id) {

        $notification = Notification::find($id);
        $notification->active = 0;
        $notification->save();

        return Redirect::back();
    }
}
