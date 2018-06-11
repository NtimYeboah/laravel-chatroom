<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    /**
     * The attributes that are mass assigned
     * 
     * @return array
     */
    protected $fillable = [
        'name', 'description', 'user_id'
    ];

    /**
     * The rooms that belongs to the user
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'room_user')
            ->withTimestamps();
    }

    /**
     * Define room relationship
     * 
     * @return mixed
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'room_id');
    }

    /**
     * Join a chat room
     * 
     * @param \App\User $user
     */
    public function join($user)
    {
        return $this->users()->attach($user);
    }

    /**
     * Leave a chat room
     * 
     * @param \App\User $user
     */
    public function leave($user)
    {
        return $this->users()->detach($user);
    }
}
