<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;
 

    public function games()
    {
        return $this->hasMany('App\Game', 'created_by', 'id');
    }

    public function games_playing() 
    {
        return $this->belongsToMany('App\Game', 'game_user', 'user_id', 'game_id');
    }

    protected $dates = ['deleted_at'];
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'nickname',
        'admin',
        'blocked',
        'reason_blocked',
        'reason_reactivated'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
}
