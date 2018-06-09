<?php

namespace App\Http\Controllers;

use App\Room;
use App\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Room $room, Request $request)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);

        $message = Message::create([
            'body' => $request->get('body'),
            'user_id' => $request->user()->id,
            'room_id' => $room->id
        ]);

        // Broadcast message created event
    }
}
