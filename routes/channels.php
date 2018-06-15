<?php

use Illuminate\Support\Facades\Auth;

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

Broadcast::channel('App.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

/**
 * Authorize room.{roomId} channel 
 * for authenticated users
 */
Broadcast::channel('room.{roomId}', function ($user, $roomId) {
    if ($user->hasJoined($roomId)) {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email
        ];
    }
});

Broadcast::channel('room.{roomId}.message', function($user, $roomId) {
    return $user->hasJoined($roomId);
});
