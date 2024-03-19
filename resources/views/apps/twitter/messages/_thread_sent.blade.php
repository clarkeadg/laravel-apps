<?php 
    use App\Models\User;

    $participantId = $thread->participantsString(Auth::id(), ['id']);
    $participant = User::where('id', $participantId)->get()->first();
?>

<a href="{{ route($app.'.messages.show', $thread->id) }}" class="block bg-white border-l border-gray-200 mb-4">
    <div class="relative flex items-center">
        <div class="flex items-center">
            <div class="w-32 flex-none bg-cover text-center overflow-hidden img-container">
                <img class="w-full" src="{{ $participant->avatar_thumb }}" alt="" />
                <h5 class="text-blue-400">{{ $participant->name }}</h5>
            </div>
        </div>
        <div class="w-75w-full px-4">
            {{ $thread->latestMessage->body }}
        </div>
        <div class="absolute top-0 right-0 pt-2 pr-4">
            ({{ $thread->userUnreadMessagesCount($participantId) }} unread)
        </div>
    </div>
</a>

