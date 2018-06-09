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
        'name', 'owner_id'
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
}
