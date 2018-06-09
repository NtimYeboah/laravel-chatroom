<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'body', 'user_id', 'room_id'
    ];

    /**
     * Define user relationship
     * 
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Define room relationship
     * 
     * @return mixed
     */
    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
