<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Game;
use App\Game_user;
use Auth;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $games = Game::paginate(5);
        return view('games.index', compact('games'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        return redirect()->route('games.index')->with('success', 'Game added successfully!'); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $game = new Game();
        $game->type = 'singleplayer';
        $game->status = 'pending';
        $game->total_players = 0;
        $game->created_by = Auth::user(); 
        $game->save();
        return redirect('home')->with('success', 'Game added successfully!');    
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $game = Game::findOrFail($id);
        $users = $game->users()->get();
        return view('games.show', compact('game', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Game::findOrFail($id)->delete();
        return redirect()->route('games.index')->with('success', 'User deleted successfully!');
    }
}
