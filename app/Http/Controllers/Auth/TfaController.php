<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\TfaLoginRequest;
use Illuminate\Http\Request;

class TfaController extends Controller
{

    public function index() {
        if(is_null(request()->user()->two_factor_secret)) abort(401);
        return view('auth.tfa.login');
    }

    public function login(TfaLoginRequest $request){
        if(is_null(request()->user()->two_factor_secret)) abort(401);
        $google2fa = app('pragmarx.google2fa');
        $verified = $google2fa->verifyKey($request->user()->two_factor_secret, $request->auth_code);
        if($verified){
            session()->put(config('auth.tfa'), true);
            return redirect()->route('dashboard');
        }
        return redirect()
            ->back()
            ->withErrors([
                __('auth.auth_code')
            ]);
    }

}
