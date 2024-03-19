<?php

use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('ChatRoom.{id}', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});

Broadcast::channel('ChatMessage.{id}', function ($user, $message) {
    return true;
});

Broadcast::channel('Messages.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('Notifications.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('Reactions.{id}', function ($user, $id) {
    return ['id' => $user->id, 'name-object_type-object_id' => $id];
});

Broadcast::channel('Tweets', function ($user, $tweet) {
    return ['id' => $user->id, 'tweet' => $tweet];
});

Broadcast::channel('Tweet.{id}', function ($user, $tweet) {
    return ['id' => $user->id, 'tweet' => $tweet];
});

Broadcast::channel('UsersOnline', function ($user) {
    return ['id' => $user->id, 'name' => $user->name];
});
