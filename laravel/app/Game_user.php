<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game_user extends Model
{
	protected $table = 'game_user';
	public $timestamps = false;
    protected $fillable = [
        'game_id',
        'user_id',
    ];
}
