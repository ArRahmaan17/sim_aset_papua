<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $user = User::where('username', $request->username)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                session()->flush();
                session(['user' => $user]);
                return redirect()->route('home');
            }
            return redirect()
                ->route('login')
                ->with("error", "Your provide <i><b>password</b></i> dons't match to our record")
                ->withInput();
        }
        return redirect()
            ->route('login')
            ->with("error", "Your provide <i><b>username</b></i> dons't exists in our application")
            ->withInput();
    }
}
