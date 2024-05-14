<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'username' => '1.1.2.22.0.0.1.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'YOHANA WORAID',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'username' => '1.1.2.14.0.0.2.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'MARLEN STEHANNY FADIRUBUN, S.KEP',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'username' => '1.3.1.4.0.0.4.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'ARIF EFENDI',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
            [
                'username' => '1.5.0.0.0.0.4.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'KRISTIAN WAY',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],  [
                'username' => '1.6.2.8.0.0.5.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'ROLAND SAMUEL RAHAKBAUW',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '2.7.3.32.0.0.6.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'PRISKA KARETH, S.IP',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '2.11.3.28.2.10.7.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'VENINA YOLANDA SIAHAYA,SE',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '2.12.0.0.0.0.8.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'YOSINA NAUW, S.SOS',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '2.15.0.0.0.0.9.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'ABU BAKAR KASTELA .S.S.I,M.AP',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '2.16.2.20.2.21.10.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'GELARDA OCE JITMAU, A.md',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '2.17.3.31.3.30.11.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'Petugas Dinas Koperasi dan Usaha...',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '2.18.0.0.0.0.12.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'EPA EDITHA ISIR, A.Md',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '2.19.3.26.0.0.13.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'LELI LORETA PAROI',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '2.23.2.24.0.0.14.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'Petugas Dinas Kearsipan Daerah....',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '3.27.2.9.3.25.15.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'YOKBET NAUW',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '4.1.0.0.0.0.16.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'Petugas Sekertariat Daerah',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '4.2.0.0.0.0.17.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'Petugas Sekertariat DRRD',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '5.1.5.5.0.0.18.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'SOPICE MABRUARU, SE',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '5.2.0.0.0.0.19.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'SARMUN',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '5.3.5.4.0.0.20.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'ASRIYUNI',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '6.1.0.0.0.0.0.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'OKTOVIANUS ANTOH, S.AN',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '8.1.0.0.0.0.22.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'YONCE BERTHA SAMOY.SE',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ], [
                'username' => '9.3.0.0.0.0.23.0',
                'password' => Hash::make('papuabaratdaya'),
                'displayname' => 'Petugas Sekertariat Majelis....',
                'nohp' => '-',
                'foto' => 'assets/profile/1.jpg',
                'idrole' => 4,
                'created_at' => now('Asia/Jakarta'),
                'updated_at' => now('Asia/Jakarta'),
            ],
        ];
        DB::beginTransaction();
        try {
            foreach ($data as $index => $data_user) {
                $id = User::insertGetId($data_user, 'idusers');
                $data_opd = [
                    'idusers' => $id,
                ];
                [
                    $data_opd['kodeurusan'],
                    $data_opd['kodesuburusan'],
                    $data_opd['kodesubsuburusan'],
                    $data_opd['kodeorganisasi'],
                    $data_opd['kodesuborganisasi'],
                    $data_opd['kodeunit'],
                    $data_opd['kodesubunit'],
                    $data_opd['kodesubsubunit'],
                ] = explode('.', $data_user['username']);
                $data_opd['tahunorganisasi'] = env('APP_YEAR');
                $data_opd['created_at'] = now('Asia/Jakarta');
                $data_opd['updated_at'] = now('Asia/Jakarta');
                DB::table('auth.users_opd')->insert($data_opd);
            }
            // DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            //throw $th;
        }
    }
}
