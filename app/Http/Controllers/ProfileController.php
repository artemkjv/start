<?php

namespace App\Http\Controllers;

use App\Http\Requests\Profile\UpdateRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit() {
        return view('profile.edit');
    }

    public function update(UpdateRequest $request){
        $payload = $request->validated();
        if(\Hash::check($payload['old_password'],\request()->user()->password)){
            $payload['password'] = \Hash::make($payload['password']);
            \request()->user()->update($payload);
            return redirect()->back();
        } else{
            return redirect()->back()->withErrors(['login' => __('auth.password')]);
        }
    }

}
