<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $routes = Route::getRoutes();
        $roles = DB::table('auth.role')
            ->where('idrole', '<>', 1)
            ->get();

        return view('layout.menu.index', compact('roles', 'routes'));
    }

    public function showDetail($id)
    {
        $data = DB::table('auth.menu')
            ->select(DB::raw(' idmenu as id, nama as text, parents as parent'))
            ->where('idmenu', $id)
            ->orWhere('parents', $id)
            ->get()->toArray();
        if (count($data) == 0) {
            $status = 404;
            $message = ['message' => 'detail menu gagal di buat', 'data' => buildTree($data)];
        } else {
            $status = 200;
            $message = ['message' => 'detail menu berhasil di buat', 'data' => buildTree($data)];
        }

        return response()->json($message, $status);
    }

    public function all()
    {
        $menuSideBar = DB::table('auth.menu')
            ->select(DB::raw(' idmenu as id, nama as text, parents as parent, letak'))
            ->where('letak', 'sidebar')
            ->where('app', session('app'))
            ->get()
            ->toArray();
        $treeMenuSideBar = buildTree($menuSideBar);
        $menuProfile = DB::table('auth.menu')
            ->select(DB::raw(' idmenu as id, nama as text, parents as parent, letak'))
            ->where('letak', 'profile')
            ->where('app', session('app'))
            ->get()->toArray();
        $treeMenuProfile = buildTree($menuProfile);
        if (count($treeMenuSideBar) == 0 && count($treeMenuProfile) == 0) {
            $response = ['message' => 'Data Menu Berhasil Di buat', 'data' => ['menu_sidebar' => $treeMenuSideBar, 'menu_profile' => $treeMenuProfile]];
            $status = 404;
        } else {
            $response = ['message' => 'Data Menu Gagal Di buat', 'data' => ['menu_sidebar' => $treeMenuSideBar, 'menu_profile' => $treeMenuProfile]];
            $status = 200;
        }

        return response()->json($response, $status);
    }

    public function updateParent(Request $request)
    {
        DB::beginTransaction();
        try {
            $menu = $request->only('menu')['menu'];
            $id = $menu['id'];
            unset($menu['text'], $menu['id']);
            DB::table('auth.menu')->where('idmenu', $id)->update($menu);
            DB::commit();
            $response = ['message' => 'menu updated successfully'];
            $status = 200;
        } catch (\Throwable $th) {
            DB::rollback();
            $response = ['message' => 'failed update menu'];
            $status = 501;
        }

        return response()->json($response, $status);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $menu = $request->except('role', '_token');
            if ($request->parents == '0-sidebar' || $request->parents == '0-profile') {
                $menu['parents'] = 0;
            }
            $menu['updated_at'] = $menu['created_at'] = now('Asia/Jakarta');
            $roles = ($request->has('role')) ? $request->only('role') : ['role' => []];
            $idmenu = DB::table('auth.menu')->insertGetId($menu, 'idmenu');
            $data_role = [];
            if ($request->has('role')) {
                foreach ($roles['role'] as $index => $role) {
                    $data_role[] = [
                        'idrole' => $role,
                        'idmenu' => $idmenu,
                        'created_at' => now('Asia/Jakarta'),
                        'updated_at' => now('Asia/Jakarta'),
                    ];
                }
            }
            $data_role[] = [
                'idrole' => 1,
                'idmenu' => $idmenu,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ];
            DB::table('auth.role_menu')->insert($data_role);
            DB::commit();
            $data = ['message' => 'menu berhasil di buat', 'data' => ['text' => $menu['nama'], 'id' => $idmenu, 'parent' => $request->parents == '0-sidebar' ? '0-sidebar' : ($request->parents == '0-profile' ? '0-profile' : $menu['parents'])]];
            $status = 200;
        } catch (\Throwable $th) {
            DB::rollBack();
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
        $menu = DB::table('auth.menu as m')
            ->join('auth.role_menu as rm', 'm.idmenu', '=', 'rm.idmenu')
            ->selectRaw('m.*, JSON_AGG(rm.idrole) as "role[]"')
            ->where('m.idmenu', $id)
            ->groupBy('m.idmenu')
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
            $data = $request->except('_token', 'role');
            if ($request->has('letak') && $request->letak == 'profile') {
                $data['parents'] = 0;
            }
            DB::table('auth.menu')->where('idmenu', $id)->update($request->except('_token', 'role'));
            DB::table('auth.role_menu')->where('idmenu', $id)->delete();
            $roles = ($request->has('role')) ? $request->only('role') : ['role' => []];
            if ($request->has('role')) {
                foreach ($roles['role'] as $index => $role) {
                    $data_role[] = [
                        'idrole' => $role,
                        'idmenu' => $id,
                        'created_at' => now('Asia/Jakarta'),
                        'updated_at' => now('Asia/Jakarta'),
                    ];
                }
            }
            $data_role[] = [
                'idrole' => 1,
                'idmenu' => $id,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ];
            DB::table('auth.role_menu')->insert($data_role);
            $status = 200;
            $message = ['message' => 'Data menu berhasil di ubah', 'data' => array_merge($request->except('_token', 'role'), ['id' => $id])];
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
            $parent = DB::table('auth.menu')->where('parents', $id)->count();
            if ($parent != 0) {
                throw new Exception('cant delete parent menu', 422);
            }
            DB::table('auth.menu')->where('idmenu', $id)->delete();
            DB::table('auth.role_menu')->where('idmenu', $id)->delete();
            DB::commit();
            $status = 200;
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
