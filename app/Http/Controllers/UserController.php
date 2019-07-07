<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\User;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('auth');
        $users = User::all();
        return view('user.all', ['active' => 'user', 'users' => $users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('auth');
        return view('user.add', ['active'=>'createUser']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('auth');
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
            'admin' => 'required|in:0,1',
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->username = $request->username;
        $user->password = Hash::make($request->password);
        $user->admin = $request->admin;

        $saved = $user->save();
        if(!$saved){
            return redirect()->back()->with(['error' => 'Something went wrong on server , please try again!']);
        }
        return redirect()->back()->with(['success' => 'The user "'.$user->username.'" created successfully']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('auth');
        $user = User::findOrFail($id);
        return view('user.edit', ['active' => 'user', 'user' => $user]);
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
        $this->authorize('auth');
        $request->validate([
            'name' => 'required',
            'admin' => 'required|in:0,1',
        ]);

        $user = User::findOrFail($id);
        $user->name = $request->name;
        if($user->admin == 0){
            $user->admin = $request->admin;
        }

        $saved = $user->save();
        if (!$saved) {
            return redirect()->back()->with(['error' => 'Something went wrong on server , please try again!']);
        }
        return redirect()->back()->with(['success' => 'The user "' . $user->username . '" edited successfully']);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);
        
        if(Hash::check($request->old_password, Auth::user()->password)){
            $user = Auth::user();
            $user->password = Hash::make($request->password);
            $saved = $user->save();
            if( !$saved ){
                return redirect()->back()->with(['error' => 'Something went wrong on server , please try again!']);
            }
            return redirect()->back()->with(['success' => 'The password changed successfully']);
        }else{
            Auth::logout();
            return redirect()->route('login')->with(['error' => 'Current password is not correct!']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('auth');
        $user = User::findOrFail($id);
        if($user->admin){
            return redirect()->back()->with(['error' => 'You can not delete an admin!' ]);
        }
        $deleted = $user->delete();
        if(!$deleted){
            return redirect()->back()->with(['error' => 'Something went wrong on server , please try again!']);
        }
        return redirect()->back()->with(['success' => 'The user "'.$user->username.'" is deleted successfully']);
    }
}
