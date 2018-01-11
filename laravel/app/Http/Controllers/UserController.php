<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Session;
use App\Game_user;
use Auth;
use Illuminate\Support\Facades\Mail;
use Mailgun\Mailgun;

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

    public function block(User $user, Request $request)
    {
        $user->blocked = $request->block;
    
        
        $user->save();

        if($request->block == 1) {
            $user->reason_blocked = $request->reasonBlocked;
            $title = 'Your account has been blocked!';
            $content = $request->reasonBlocked;
            $flag = 1;
            $message =  $user->nickname . ' Block';
            
        } else {
            $title = 'Your account has been Unlocked!';
            $content = $request->reasonBlocked;
            $flag = 0;
            $message =  $user->nickname . ' Unblocked';
        }

        Session::flash('message', $message);
        Mail::send('emails.send', ['title' => $title, 'content' => $content, 'flag' => $flag], function ($message) use ($user)
        {
            $message->from('dadproj122@gmail.com', 'Projeto DAD');
            $message->subject('ProjDAD 122');
            $message->to($user->email);
        });
        return  redirect()->route('users.index');    
    }

    

    public function blockUser(User $user, Request $request)
    {
        return view('adminPanel.users.blockuser', compact('user'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
        return view('adminPanel.users.add');
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $user = new User();
        $user->fill($request->all());
        $user->password = Hash::make($request->password);
        $user->
        $user->save();
        return redirect()->route('users.index')->with('success', 'User added successfully!');
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
        return redirect()->route('adminPanel.users.index');
    }
}
