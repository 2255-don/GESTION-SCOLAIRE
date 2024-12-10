<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function Login(){
        return view('admin.login');
    }

    public function doLogin(Request $request){
        $credential = $request->only('email', 'password');
        if(Auth::attempt($credential)){
            $request->session()->regenerate();
            $user = Auth::user();
            if($user->profil && $user->profil->libelle == 'superadmin'){
                // dd('superadmin');
                return redirect()->route('supadmin.user');
            }elseif($user->profil && $user->profil->libelle == 'admin'){
                return redirect()->route('admin.dashboard');
            }else{
                return redirect()->route('prof.acceuil');
            }
        }
    }

    //bouton de deconnexion
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('user.login');
    }
}
