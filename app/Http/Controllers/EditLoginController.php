<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;

class EditLoginController extends Controller
{
    public function index()
    {
        $users = User::get();

        return view('index', compact('users'));
    }

    public function show($id)
    {
        // $user = User::where('id', $id)->get();
        if(!$user = User::find($id))
            return redirect()->route('index');

        return view('show', compact('user'));
    }

    public function edit($id)
    {
        if (!$user = User::find($id))
            return redirect()->route('/welcome');

        return view('edit');
    }

    public function updateLogin(LoginRequest $request, $id)
    {
        if (!$user = User::find($id))
            return redirect()->route('/welcome');

        $data = $request->only('name', 'email');
        if ($request->password)
            $data['password'] = bcrypt($request->password);
   
        $user->update($data);

        return redirect()->route('dashboard');
    }
}
