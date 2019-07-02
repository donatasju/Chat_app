<?php

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

Broadcast::channel('messages.{id}', function ($user, $id) {
//    dump("userio id is channels: $id ir useris $user");
    return $user->id === (int) $id;
});



Broadcast::channel('rooms.{room_id}', function ($room_id, $user_id) {
//    dump("roomo id is channels $room_id, ir userio id $user_id");
    return true;
//    return $user->id === (int) $id;
});
