<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateNotificationRequest;
use App\Http\Requests\UpdateNotificationRequest;
use App\Models\Notification;

class NotificationController extends Controller
{
    public function index()
    {
        return response()->json([
            'message' => 'Notification created successfully',
            'data' =>[
                'notifications' => Notification::paginate(20)
            ]
        ], 200);
    }

    public function show(Notification $notification)
    {
        return response()->json([
            'message' => 'Notification Found',
            'data' => [
                'notification' => $notification
            ]
        ]);
    }

    public function create(CreateNotificationRequest $request)
    {
        $notification = Notification::create($request->validated());

        return response()->json([
            'message' => 'Notification created successfully',
            'data' =>[
                'notification' => $notification
            ]
        ], 200);
    }

    public function update(UpdateNotificationRequest $request, Notification $notification)
    {
        $notification->update($request->validated());

        return response()->json([
            'message' => 'Notification updated successfully',
            'data' => [
                'notification' => $notification
            ]
        ]);
    }

    public function delete(Notification $notification)
    {
        $notification->delete();

        return response()->json(['message' => 'Notification deleted successfully']);
    }
}
