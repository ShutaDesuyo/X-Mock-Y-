<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()
            ->appNotifications()
            ->with(['actor', 'target'])
            ->latest()
            ->paginate(30);

        Auth::user()->appNotifications()->whereNull('read_at')->update(['read_at' => now()]);

        return view('notifications.index', compact('notifications'));
    }
}
