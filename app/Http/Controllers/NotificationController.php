<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function clearnotification($id){
        $q = Notification::where('userid', $id)->update(['is_read' => 1]);
        if ($q) {
            return response(['status' => 1]);
        } else {
            return response(['status' => 2]);
        }
    }
}
