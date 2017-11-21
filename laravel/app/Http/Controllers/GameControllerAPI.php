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
    	$games = Game::all();
    	foreach ($games as $game) {
    		$game['created_by'] = $game->user->nickname;
    	}
    	return $games;
    	//return Game::all();
    }    

    public function delete($id)
    {	
		Game::findOrFail($id)->delete();
        return redirect()->route('games.index')->with('success', 'Game deleted successfully!'); 
    }

    public function show($id)
    {
        $game = Game::findOrFail($id);
        $users = $game->users()->get();
        return view('games.show', compact('game', 'users'));
    }

}
