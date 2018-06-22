<?php

namespace App\Http\Controllers;

use App\Room;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Events\MessageCreated;
use Illuminate\Support\Facades\Log;

class MessagesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $message = Message::create([
                'body' => $request->get('body'),
                'user_id' => $request->user()->id,
                'room_id' => $request->get('room_id')
            ]);

            broadcast(new MessageCreated($message->load('user')))->toOthers();
        } catch (Exception $e) {
            Log::error('Error occurred whiles creating a message', [
                'file' => $e->getFile(),
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);

            return response()->json([
                'msg' => 'Error creating message', 
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        return response()->json([
            'msg' => 'Message created'
        ], Response::HTTP_CREATED);   
    }
}
