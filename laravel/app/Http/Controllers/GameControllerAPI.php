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

    public function store() 
    {
        $game = new Game();
        $game_user = new Game_user();
        $game->type = 'singleplayer';
        $game->status = 'pending';
        $game->total_players = 1;
        $game->created_by = Auth::user()->id; 
        $game->save();
        $game_user->game_id = $game->id;
        $game_user->user_id = $game->created_by;
        $game_user->save();
        return redirect()->route('adminPanel.games.index')->with('success', 'Game added successfully!'); 
    }

    public function joinGame($id) 
    {
        $game = Game::findOrFail($id);
        $game_user = new Game_user();
        if ($game->total_players < 5) 
        {
            $game->total_players++;
            $game->status = 'multiplayer';
        }
        $game->save();
        $game_user->game_id = $game->id;
        $game_user->user_id = Auth::user();
        $game_user->save();
        return redirect()->route('adminPanel.games.index')->with('success', 'Game added successfully!'); 
    }


    public function delete($id)
    {	
		Game::findOrFail($id)->delete();
        return redirect()->route('adminPanel.games.index')->with('success', 'Game deleted successfully!'); 
    }

    public function show($id)
    {
        $game = Game::findOrFail($id);
        $users = $game->users()->get();
        return view('adminPanel.games.show', compact('game', 'users'));
    }

}
