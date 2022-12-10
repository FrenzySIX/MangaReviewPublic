<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;

class EditLoginController extends Controller
{
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
