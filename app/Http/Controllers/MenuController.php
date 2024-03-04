<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use PHPUnit\Event\Code\Throwable;

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
        $roles = ($request->has('role')) ? $request->only('role') : ['role' => []];
        $idmenu = DB::table('menu')->insertGetId($menu, 'idmenu');
        $data_role = [];
        if ($request->has('role')) {
            foreach ($roles['role'] as $index => $role) {
                $data_role[] = [
                    'idrole' => $role,
                    'idmenu' => $idmenu,
                    'created_at' => now('Asia/Jakarta'),
                    'updated_at' => now('Asia/Jakarta')
                ];
            }
        }
        $data_role[] = [
            'idrole' => 1,
            'idmenu' => $idmenu,
            'created_at' => now('Asia/Jakarta'),
            'updated_at' => now('Asia/Jakarta')
        ];
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try {
            DB::table('menu')->where('idmenu', $id)->update($request->except('_token', 'role'));
            DB::table('role_menu')->where('idmenu', $id)->delete();
            $roles = ($request->has('role')) ? $request->only('role') : ['role' => []];
            if ($request->has('role')) {
                foreach ($roles['role'] as $index => $role) {
                    $data_role[] = [
                        'idrole' => $role,
                        'idmenu' => $id,
                        'created_at' => now('Asia/Jakarta'),
                        'updated_at' => now('Asia/Jakarta')
                    ];
                }
            }
            $data_role[] = [
                'idrole' => 1,
                'idmenu' => $id,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta')
            ];
            DB::table('role_menu')->insert($data_role);
            $status = 200;
            $message = ['message' => 'Data menu berhasil di ubah', 'data' => $request->except('_token', 'role')];
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            $message = ['message' => 'Data menu gagal di ubah', 'data' => []];
            $status = 422;
        }
        return response()->json($message, $status);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $parent = DB::table('menu')->where('parents', $id)->count();
            if ($parent != 0) {
                throw new Exception("cant delete parent menu", 422);
            }
            DB::table('menu')->where('idmenu', $id)->delete();
            DB::table('role_menu')->where('idmenu', $id)->delete();
            DB::commit();
            $status = 422;
            $message = ['message' => 'berhasil menghapus menu'];
        } catch (\Exception $th) {
            DB::rollBack();
            $message = ['message' => 'gagal menghapus menu'];
            if ($th->getCode() == 422) {
                $message = ['message' => $th->getMessage()];
            }
            $status = 422;
        }
        return response()->json($message, $status);
    }
}
