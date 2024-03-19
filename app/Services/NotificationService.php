<?php

namespace App\Services;

use App\Models\Notification;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NotificationService
{
    // Create
    public function create($userId, $name, $object_type, $object_id)
    {
        $notification = new Notification;
        $notification->user_id = $userId;
        $notification->name = $name;
        $notification->object_type = $object_type;
        $notification->object_id = $object_id;
        $notification->save();

        return $notification;
    }

    // Read
    
    public function get($userId, $page=1, $limit=10)
    {       
        $query = Notification::where('user_id', $userId);           

        $count = $query->count();

        $data = $query
            ->with(['object.media'])
            ->orderBy('id', 'desc')
            ->offset(($page-1)*$limit)
            ->limit($limit)
            ->get();

        return [
            'items' => $data,
            'count' => $count,
        ];
    }

    public function getCount($userId)
    {       
        return Notification::where('user_id', $userId)
                            ->whereNull('read')
                            ->count();
    }

    // Update

    public function markAllRead($userId)
    {
        DB::table('notifications')
            ->where('user_id', $userId)
            ->whereNull('read')
            ->update(['read' => Carbon::now()]); 
    }

    public function markRead($userId, $id)
    {
        $notification = Notification::where('id', $id)
                                    ->where('user_id', $userId)
                                    ->first(); 

        if (isset($notification) && !$notification->read) {
            $notification->read = Carbon::now();
            $notification->save();                                
        }

        return $notification;               
    }

    // Delete
}
