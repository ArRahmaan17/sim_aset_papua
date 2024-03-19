<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MasterController;
use App\Models\User;
use Illuminate\Contracts\Session\Session;
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
                return redirect()->route('select-application');
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

    public function setOrganisasi(Request $request)
    {
        $organisasi = (new MasterController)->masterOrganisasi($request);
        $request->session()->put('organisasi', $organisasi);
        return response()->json(['status' => true, 'redirect' => route('home')], $organisasi ? 200 : 400);
    }
    public function logout()
    {
        session()->forget('app');
        return redirect()->route('home');
    }
    public function logout_system()
    {
        session()->flush();
        return redirect()->route('home');
    }
}
