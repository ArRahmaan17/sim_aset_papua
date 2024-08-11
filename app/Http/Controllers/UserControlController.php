<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserControlController extends Controller
{
    public function index()
    {
        return view('layout.control.index');
    }

    public function dataTable(Request $request)
    {
        $totalData = DB::table('auth.role')

            ->orderBy('role', 'asc')
            ->count();
        $totalFiltered = $totalData;
        if (empty($request['search']['value'])) {
            $assets = DB::table('auth.role')
                ->select('*');
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('role ' . $request['order'][0]['dir']);
            }
            $assets = $assets->get();
        } else {
            $assets = DB::table('auth.role')->select('*')
                ->where('role', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $assets->orderByRaw('role ' . $request['order'][0]['dir']);
            }
            if ($request['length'] != '-1') {
                $assets->limit($request['length'])
                    ->offset($request['start']);
            }
            $assets = $assets->get();

            $totalFiltered = DB::table('auth.role')
                ->select('*')
                ->where('role', 'like', '%' . $request['search']['value'] . '%');
            if (isset($request['order'][0]['column'])) {
                $totalFiltered->orderByRaw('role ' . $request['order'][0]['dir']);
            }
            $totalFiltered = $totalFiltered->count();
        }
        $dataFiltered = [];
        foreach ($assets as $index => $item) {
            $row = [];
            $row[] = $request['start'] + ($index + 1);
            $row[] = '' . $item->role;
            $row[] = "<button class='btn btn-warning edit' ><i class='bx bxs-pencil'></i> Edit</button><button class='btn btn-danger delete'><i class='bx bxs-trash-alt' ></i> Hapus</button>";
            $row[] = $item->idrole;
            $dataFiltered[] = $row;
        }
        $response = [
            'draw' => $request['draw'],
            'recordsFiltered' => $totalFiltered,
            'recordsTotal' => count($dataFiltered),
            'aaData' => $dataFiltered,
        ];

        return Response()->json($response, 200);
    }

    public function profileChange(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except('_token');
            if ($request->file('foto')) {
                if (is_dir(public_path('assets/profile/')) == false) {
                    mkdir(public_path('assets/profile/'));
                }
                $filename = 'assets/profile/' . session('user')->idusers . '.jpg';
                file_put_contents(public_path($filename), file_get_contents($_FILES['foto']['tmp_name']));
                $data['foto'] = $filename;
            }
            $id = session('user')->idusers;
            DB::table('auth.users')
                ->where('idusers', $id)
                ->update($data);
            DB::commit();
            $status = 200;
            $message = ['message' => 'Profile user berhasil di ubah'];
            $data = DB::table('auth.users')->where('idusers', $id)->first();
            session()->forget('user');
            session()->put('user', $data);
        } catch (Throwable $th) {
            DB::rollBack();
            $status = 422;
            $message = ['message' => 'Profile user gagal di ubah'];
        }

        return response()->json($message, $status);
    }

    public function passwordChange(Request $request)
    {
        DB::beginTransaction();
        try {
            $id = session('user')->idusers;
            if ($request->newpassword == $request->password && $request->confirm == 'on') {
                DB::table('auth.users')
                    ->where('idusers', $id)
                    ->update(['password' => Hash::make($request->password)]);
            } elseif ($request->newpassword != $request->password) {
                throw new Exception('password saat ini dan password baru tidak sama', 422);
            } else {
                throw new Exception('mohon untuk melakukan konfirmasi perubahan password', 422);
            }
            DB::commit();
            $status = 200;
            $message = ['message' => 'password user berhasil di ubah'];
        } catch (Throwable $th) {
            DB::rollBack();
            $status = 422;
            $message = ['message' => 'password user gagal di ubah'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
        }

        return response()->json($message, $status);
    }

    public function roleStore(Request $request)
    {
        DB::beginTransaction();
        try {
            $data = $request->except('_token');
            $data['app'] = (session('app') == 'aset') ? 1 : 2;
            DB::table('auth.role')->insert($data);
            DB::commit();
            $status = 200;
            $message = ['message' => 'Role user berhasil ditambahkan'];
        } catch (Exception $th) {
            $message = ['message' => 'Role user gagal ditambahkan'];
            $status = 422;
            DB::rollBack();
        }

        return response()->json($message, $status);
    }

    public function roleShow(string $id)
    {
        $data = DB::table('auth.role')->where('idrole', $id)->first();
        if ($data) {
            $status = 200;
            $message = ['message' => 'data role berhasil di temukan', 'data' => $data];
        } else {
            $status = 404;
            $message = ['message' => 'data role gagal di temukan', 'data' => $data];
        }

        return response()->json($message, $status);
    }

    public function roleUpdate(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            DB::table('auth.role')->where('idrole', $id)->update($request->except('_token'));
            DB::commit();
            $status = 200;
            $message = ['message' => 'Role user berhasil di ubah'];
        } catch (Exception $th) {
            $message = ['message' => 'Role user gagal di ubah'];
            $status = 422;
            DB::rollBack();
        }

        return response()->json($message, $status);
    }

    public function roleDestroy(string $id)
    {
        DB::beginTransaction();
        try {
            DB::table('auth.role')
                ->where('idrole', $id)
                ->delete();
            DB::commit();
            $message = ['message' => 'berhasil menghapus role user'];
            $status = 200;
        } catch (Exception $th) {
            DB::rollBack();
            $message = ['message' => 'gagal menghapus role user'];
            $status = 422;
        }

        return response()->json($message, $status);
    }

    public function roleCreate()
    {
        return view('layout.control.role-create');
    }

    public function userCreate()
    {
        $roles = DB::table('auth.role')
            ->where('idrole', '>=', session('user')->idrole)->get();
        $semuaorganisasi = (new OrganisasiController)->useable()->getData()->data;

        return view('layout.control.user-create', compact('roles', 'semuaorganisasi'));
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'idrole' => 'required',
        ], [
            'username.required' => 'nik user mohon di isi',
            'idrole.required' => 'role user mohon di isi',
        ]);
        DB::beginTransaction();
        try {
            $data = $request->except('_token');
            $data['password'] = Hash::make((!$request->exists('password')) ? 'papuabaratdaya' : $request->password);
            $data['displayname'] = (!$request->exists('displayname')) ? $data['username'] : $request->displayname;
            if (intval($request->idrole) != 1) {
                if (isset($data['useropd'])) {
                    [
                        $user_opd['kodeurusan'],
                        $user_opd['kodesuburusan'],
                        $user_opd['kodesubsuburusan'],
                        $user_opd['kodeorganisasi'],
                        $user_opd['kodesuborganisasi'],
                        $user_opd['kodeunit'],
                        $user_opd['kodesubunit'],
                        $user_opd['kodesubsubunit'],
                    ] = explode('.', $data['useropd']);
                    $organisasi = DB::table('masterorganisasi')->where($user_opd)->first();
                    $user_opd['organisasi'] = $organisasi->organisasi;
                    $user_opd['tahunorganisasi'] = $organisasi->tahunorganisasi;
                } else {
                    $user_opd = (array) clone (session('organisasi'));
                    unset($user_opd['wajibsusut'], $user_opd['organisasi']);
                    $user_opd['organisasi'] = DB::table('masterorganisasi')->where($user_opd)->first()->organisasi;
                }
                unset($data['useropd']);
            }
            $id = DB::table('auth.users')->insertGetId($data, 'idusers');
            if (intval($request->idrole) != 1) {
                $user_opd['idusers'] = $id;
                $user_opd['created_at'] = now('Asia/Jakarta');
                $user_opd['updated_at'] = now('Asia/Jakarta');
                DB::table('auth.users_opd')->insert($user_opd);
                if (DB::table('auth.role_menu')->where('idrole', $request->idrole)->count() == 0) {
                    DB::table('auth.role_menu')->insert([
                        'idrole' => $request->idrole,
                        'idmenu' => (session('app') == 'aset') ? DB::table('auth.menu')->where('app', session('app'))->orderBy('idmenu', 'asc')->first()->idmenu : DB::table('auth.menu')->where('app', session('app'))->orderBy('idmenu', 'asc')->first()->idmenu,
                        'created_at' => now('Asia/Jakarta'),
                        'updated_at' => now('Asia/Jakarta'),
                    ]);
                }
            }
            $status = 200;
            $response = ['message' => 'Tambah user berhasil'];
            DB::commit();
        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            $status = 422;
            $response = ['message' => 'Tambah user gagal'];
        }

        return response()->json($response, $status);
    }
}
