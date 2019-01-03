<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = User::findOrFail(Auth::user()->id);
        $notifications = $user->unreadNotifications;
        return view('notification.index', ['notifications' => $notifications]);
    }

    public function view($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();
        return redirect($notification->data['url']);
    }

    public function countUnread()
    {
        return response()->json([
            'unread' => Auth::user()->unreadNotifications->count()
        ]);
    }

    public function getUnread()
    {
        return response()->json([
            'unread' => Auth::user()->unreadNotifications
        ]);
    }
}
