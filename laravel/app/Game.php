<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    public function user()
    {
        return $this->belongsTo('App\User', 'created_by', 'id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'game_user', 'game_id', 'user_id');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'status',
        'total_players',
        'created_by',
        'winner',
    ];


}
