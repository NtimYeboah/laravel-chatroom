<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoomsController extends Controller
{
    /**
     * Display a listing of the chat rooms.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::with('owner')->paginate();

        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a chat room.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $room = app(Room::class);

        return view('rooms.create', compact('room'));
    }

    /**
     * Store a newly created room in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required'
        ]);

        try {
            Room::create([
                'name' => $request->get('name'),
                'description' => $request->get('description'),
                'owner_id' => $request->user()->id
            ]);
        } catch (Exception $e) {
            Log::error('Exception while creating a chatroom', [
                'file' => $e->getFile(),
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
        }

        return redirect()->route('rooms.index');  
    }

    /**
     * Show room with messages
     * 
     * @param mixed $room
     */
    public function show(Room $room)
    {
        $messages = Room::with('messages')->get();

        return view('room.show', compact('messages'));
    }
}
