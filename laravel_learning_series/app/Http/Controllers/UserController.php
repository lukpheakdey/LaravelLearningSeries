<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\User;

class UserController extends Controller
{
    public function index(){
        $users =  User::all();

        //dd($user);
        return view("users", compact('users'));
    }

    public function create(){
        return view("create");
    }

    public function store(UserRequest $request){

        $validator = \Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6'
        ]);
        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => $request->get('password'),
        ]);

        //Session::flash('success', 'User create successfully.');
        return redirect('/users');
    }

    public function edit($id){
        $user = User::find($id);
        if (empty($user)) {
            //\Session::flash('error', 'User not found');
            return redirect('users');
        }
        return view('edit', compact('user'));
    }


    public function update($id, Request $request)
    {
        $user = User::find($id);
        if (empty($user)) {
            //\Session::flash('error', 'User not found');
            return redirect('users');
        }
        $user->update([
            'name' => $request->get('name'),
            'email' => $request->get('email')
        ]);
        // pass data to notification class
        // $user->notify(new UserNotification([
        //     'message' => 'Your profile updated.'
        // ]));
        //\Session::flash('success', 'User updated successfully.');
        return redirect('/users');
    }

    public function show($id)
    {
        $user = User::find($id);
        if (empty($user)) {
            //\Session::flash('error', 'User not found');
            return redirect('users');
        }
        return view('detail', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::find($id);
        if (empty($user)) {
            //\Session::flash('error', 'User not found');
            return redirect('users');
        }
        $user->delete();
        //\Session::flash('success', 'User deleted successfully.');
        return redirect('users');
    }

}
