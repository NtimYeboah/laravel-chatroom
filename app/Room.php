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
        'name', 'description', 'owner_id'
    ];

    /**
     * Define owner relationship
     * 
     * @return mixed
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
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
}
