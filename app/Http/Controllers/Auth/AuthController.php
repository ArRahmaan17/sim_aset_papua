<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Controllers\MasterController;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
                $organisasi = DB::table('auth.users_opd as uo')->select('mo.*')->join('masterorganisasi as mo', function (JoinClause $join) {
                    $join->on('uo.kodeurusan', '=', 'mo.kodeurusan')
                        ->on('uo.kodesuburusan', '=', 'mo.kodesuburusan')
                        ->on('uo.kodesubsuburusan', '=', 'mo.kodesubsuburusan')
                        ->on('uo.kodeorganisasi', '=', 'mo.kodeorganisasi')
                        ->on('uo.kodesuborganisasi', '=', 'mo.kodesuborganisasi')
                        ->on('uo.kodeunit', '=', 'mo.kodeunit')
                        ->on('uo.kodesubunit', '=', 'mo.kodesubunit')
                        ->on('uo.kodesubsubunit', '=', 'mo.kodesubsubunit');
                })->where('uo.idusers', $user->idusers)->first();
                session()->flush();
                session(['user' => $user, 'organisasi' => $organisasi]);

                return redirect()->route('select-application');
            }

            return redirect()
                ->route('login')
                ->with('error', "Your provide <i><b>password</b></i> dons't match to our record")
                ->withInput();
        }

        return redirect()
            ->route('login')
            ->with('error', "Your provide <i><b>username</b></i> dons't exists in our application")
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
        session()->forget('organisasi');

        return redirect()->route('home');
    }

    public function logout_system()
    {
        session()->flush();

        return redirect()->route('home');
    }
}
