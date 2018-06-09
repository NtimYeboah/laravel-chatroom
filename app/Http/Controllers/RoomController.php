<?php

namespace App\Http\Controllers;

use App\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoomController extends Controller
{
    /**
     * Display a listing of the chat rooms.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rooms = Room::with('owner')->paginate();

        return view('room.index', compact($rooms));
    }

    /**
     * Show the form for creating a chat room.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$room = app(Room::class)->make();

        return view('room.create', compact($room));
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
            'name' => ''
        ]);

        try {
            Room::create([
                'name' => $request->get('name'),
                'owner_id' => $request->user()->id
            ]);
        } catch (Exception $e) {
            Log::error('Exception while creating a chatroom', [
                'file' => $e->getFile(),
                'code' => $e->getCode(),
                'message' => $e->getMessage(),
            ]);
        }

        return redirect()->route('room.index');  
    }
}
