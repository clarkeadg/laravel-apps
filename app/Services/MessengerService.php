<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Cmgmyr\Messenger\Models\Message;
use Cmgmyr\Messenger\Models\Participant;
use Cmgmyr\Messenger\Models\Thread;
use Carbon\Carbon;

class MessengerService
{
    // Create

    public function createThread($subject="new message")
    {
        return Thread::create([
            'subject' => $subject,
        ]);
    }

    public function createMessage($threadId, $userId, $message)
    {
        return Message::create([
            'thread_id' => $threadId,
            'user_id' => $userId,
            'body' => $message,
        ]);
    }

    public function createParticipant($threadId, $userId)
    {
        return Participant::firstOrCreate([
            'thread_id' => $threadId,
            'user_id' => $userId,
            'last_read' => new Carbon(),
        ]);
    }

    public function addParticipant($thread, $userId)
    {
        $thread->addParticipant($userId);
    }

    // Read  

    public function getUnreadCount()
    {
        $count = 0;
        $user = Auth::user();  
        if (isset($user)) {
            $count = $user->newThreadsCount();
        }
        return $count;
    }

    public function getThreadById($id)
    {
        return Thread::find($id);
    }

    public function getList($userId)
    {
        // All threads, ignore deleted/archived participants
        //$threads = Thread::getAllLatest()->get();

        // All threads that user is participating in
        $data = Thread::forUser($userId)->latest('updated_at')->get();

        // All threads that user is participating in, with new messages
        //$threads = Thread::forUserWithNewMessages($user->id)->latest('updated_at')->get();

        $count = $data->count();

        return [
            'items' => $data,
            'count' => $count,
        ];
    }

    // Update

    public function markRead($thread, $userId)
    {
        $thread->markAsRead($userId);
    }

    // Delete
}
