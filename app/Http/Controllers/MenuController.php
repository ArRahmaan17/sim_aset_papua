<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes = Route::getRoutes();
        $roles = DB::table('role')->where('idrole', '<>', 1)->get();
        return view('layout.menu.index', compact('roles', 'routes'));
    }

    public function all()
    {
        $menu = DB::table('menu')->select(DB::raw(' idmenu as id, nama as text, parents as parent'))->get()->toArray();
        $treeMenu = buildTree($menu);
        if (count($treeMenu) == 0) {
            $response = ['message' => 'Data Menu Berhasil Di buat', 'data' => $treeMenu];
            $status = 404;
        } else {
            $response = ['message' => 'Data Menu Gagal Di buat', 'data' => $treeMenu];
            $status = 200;
        }
        return response()->json($response, $status);
    }

    public function updateParent(Request $request)
    {
        $menu = $request->only('menu')['menu'];
        $id = $menu['id'];
        unset($menu['text'], $menu['id']);
        $update = DB::table('menu')->where('idmenu', $id)->update($menu);
        if ($update) {
            $response = ['message' => "menu updated successfully"];
            $status = 200;
        } else {
            $response = ['message' => "failed update menu"];
            $status = 501;
        }
        return response()->json($response, $status);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $menu = $request->except('role', '_token');
        $menu['updated_at'] = $menu['created_at'] = now('Asia/Jakarta');
        $roles = isset($request->only('role')) ? $request->only('role') : ['role' => []];
        $idmenu = DB::table('menu')->insertGetId($menu, 'idmenu');
        $data_role = [];
        foreach ($roles['role'] as $index => $role) {
            $data_role[] = [
                'idrole' => $role,
                'idmenu' => $idmenu,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta')
            ];
        }
        $insertStatus = DB::table('role_menu')->insert($data_role);
        if ($insertStatus) {
            $data = ['message' => 'menu berhasil di buat', 'data' => ['text' => $menu['nama'], 'id' => $idmenu, 'parent' => $menu['parents']]];
            $status = 200;
        } else {
            $data = ['message' => 'menu gagal di buat', 'data' => []];
            $status = 400;
        }
        return response()->json($data, $status);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $menu = DB::table('menu as m')
            ->join('role_menu as rm', 'm.idmenu', '=', 'rm.idmenu')
            ->selectRaw('m.*, JSON_ARRAYAGG(rm.idrole) as "role[]"')
            ->where('m.idmenu', $id)
            ->groupBy('idmenu')
            ->first();
        if ($menu) {
            $data = ['message' => 'data menu berhasil di dapatkan', 'data' => $menu];
            $status = 200;
        } else {
            $data = ['message' => 'data menu gagal di dapatkan', 'data' => []];
            $status = 404;
        }
        return response()->json($data, $status);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
