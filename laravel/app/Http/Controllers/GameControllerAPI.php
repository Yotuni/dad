<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Game_user;
use Auth;

class GameControllerAPI extends Controller
{
	public function all()
    {
        return Game::paginate(5);
    }    

    public function delete($id)
    {	
		Game::findOrFail($id)->delete();
        return redirect()->route('games.index')->with('success', 'Game deleted successfully!'); 
    }
}
