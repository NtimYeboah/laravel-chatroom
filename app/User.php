<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Define room relationship
     * 
     * @return mixed
     */
    public function rooms()
    {
        return $this->hasMany(Room::class, 'owner_id');
    }

    /**
     * Define messages relation
     * 
     * @return mixed
     */
    public function messages()
    {
        return $this->hasMany(Message::class, 'user_id');
    }
}
