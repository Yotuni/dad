<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Session;
use App\Game_user;
use Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    

    public function index()
    {
        $users = User::all();
        return view('adminPanel.users.index', compact('users'));
    }

    public function listRemovedUsers()
    {
        $users = User::onlyTrashed()->get();
        return view('adminPanel.users.listRemovedUsers', compact('users'));
    }

    public function recoverUser($id)
    {
        $userDeleted = User::withTrashed()->find($id)->restore();
        return redirect()->route('listRemovedUsers');
    }


    public function blockUser(User $user, Request $request)
    {
        $user->blocked = $request->block;
        $user->save();
        if($request->block == 1) {
            Session::flash('message', 'User blocked!');
        } else {
            Session::flash('message', 'User unblocked!');
        }
        return  redirect()->route('users.index');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
 
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
        $user = User::findorfail($id);
        $user->delete();
        return redirect()->route('users.index');
    }
}
